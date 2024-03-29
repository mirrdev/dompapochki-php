jQuery(document).ready(function($) {
    // const state = {promocode: paramCart || null};
    var cartWrapper = $('.cd-cart-container');
    var cartTable = $('.cart-table');
    var cartEnd = $('.cart-end');

    var promoEl = document.querySelector('#submitpromo');
    var infoAlert = document.querySelector('#info-alert');
    var valueInput = document.querySelector(`input[name="promocode"]`);
    var checkoutEl = document.querySelector('.checkout>span');


    // const phone = $("#phone").mask("+375 (99) 999-99-99");
    const phone = $("#phone");
    phone.on('propertychange input', function (e) {
            const valuePhone = phone.val();
            const regEx = new RegExp(/^\s*(\+?375|80)((33\d{7})|(29\d{7})|(44\d{7}|)|(25\d{7}))\s*$/);
            if (regEx.test(valuePhone) && valuePhone.length > 8) {
                phone.removeClass('is-invalid').addClass('is-valid');
                $('.btn.btn-success.btn-lg').attr('disabled', false);
            } else {
                phone.removeClass('is-valid').addClass('is-invalid');
                $('.btn.btn-success.btn-lg').attr('disabled', true);
            }
    });


    //product id - you don't need a counter in your real project but you can use your real product id
    var productId = 0;

    if( cartEnd.length > 0 ) {
        localStorage.setItem("cartItems", '');
        localStorage.setItem("countProductInCart", '');
    }
    if( cartWrapper.length > 0 ) {
        //store jQuery objects
        var cartBody = cartWrapper.find('.body')
        var cartList = cartBody.find('ul').eq(0);
        var cartTotal = cartWrapper.find('.checkout').find('span');
        var cartTrigger = cartWrapper.children('.cd-cart-trigger');
        var cartCount = cartTrigger.children('.count');
        var addToCartBtn = $('.cd-add-to-cart');
        var undo = cartWrapper.find('.undo');
        var undoTimeoutId;

        //add product to cart
        addToCartBtn.on('click', function(event){
            event.preventDefault();
            var el = $(this);
            var trigger = {
                id: el.data('id'),
                title: el.data('title'),
                type: el.data('type'),
                price: el.data('price'),
                detail: el.data('detail'),
                img: el.data('img'),
                url: el.data('url'),
                count: el.data('count'),
                category: el.data('category'),
                guid: getRandomArbitrary(100000, 900000)
            };
            addToCart(trigger, true);
        });

        //init card (reload page)
        if (localStorage.getItem("cartItems") !== null) {
            initCart();
        }

        //open/close cart
        cartTrigger.on('click', function(event){
            // event.preventDefault();
            // toggleCart();
            // window.location = '/cart';
        });

        //close cart when clicking on the .cd-cart-container::before (bg layer)
        cartWrapper.on('click', function(event){
            if( $(event.target).is($(this)) ) toggleCart(true);
        });

        //delete an item from the cart
        cartList.on('click', '.delete-item', function(event){
            event.preventDefault();
            removeProduct($(event.target).parents('.product'));
        });

        //update item quantity
        cartList.on('change', 'select', function(event){
            quickUpdateCart();
        });

        //reinsert item deleted from the cart
        undo.on('click', 'a', function(event){
            clearInterval(undoTimeoutId);
            event.preventDefault();
            cartList.find('.deleted').addClass('undo-deleted').one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(){
                $(this).off('webkitAnimationEnd oanimationend msAnimationEnd animationend').removeClass('deleted undo-deleted').removeAttr('');
                quickUpdateCart();
            });
            undo.removeClass('visible');
        });
    }
    if( cartTable.length > 0 ) {
        if(localStorage.getItem("cartItems") !== undefined && localStorage.getItem("cartItems") !== null && localStorage.getItem("cartItems") !== '')
        {
            var cartTableBody = cartTable.find('tbody');
            cartTotal = cartTable.find('.checkout').find('span');
            addressBox = cartTable.find('#address-box');
            promoCode = cartTable.find('#promocode');
            initTable();

            //delete an item from the cart
            cartTable.on('click', '.delete-item', function(event){
                event.preventDefault();
                removeProductInCartTable($(event.target).parents('.product'));
            });

            cartTable.on('click', '.btn-minus', function(event){
                event.preventDefault();
                removeProductInCartTable($(event.target).parents('.product'));
            });

            cartTable.on('click', '.btn-plus', function(event){
                event.preventDefault();
                addProductInCartTable($(event.target).parents('.product'));
            });



            const renderPromo = (state) => {
                if (!state.promoCode.isPromoCodeEnabled) {
                    return;
                }

                if (!state.promoCode.validatedStatus) {
                    initTable();
                    return;
                }
                if (state.promoCode.validatedStatus) {

                }
            };
            if (valueInput !== null) {
            valueInput.addEventListener('input', function(e) {
            e.preventDefault();
            infoAlert.className = "text-center";
            infoAlert.innerHTML = '';
           });

           promoEl.addEventListener('click', function(event) {
            event.preventDefault();
            const currentValue = (valueInput.value).toLowerCase().replace(/\s+/gi, "");
            valueInput.focus();
            // renderPromo(state);
            initTable({ currentValue });
           });
        }
            cartTable.on('change', '#deliverytype1', function(event){
                event.preventDefault();
                showHideFormAddress(false);
                if (promoCode.length > 0) {
                    showHidePromoCode(false);
                }
                initTable();
            });

            cartTable.on('change', '#deliverytype2', function(event){
                event.preventDefault();
                showHideFormAddress(true);
                if (promoCode.length > 0) {
                    showHidePromoCode(true);
                }
                initTable();
            });
        }
        else{
            cartTable.empty();
            cartTable.text('Корзина пуста');
        }
    }

    function initTable(param = {}) {
        showHideFormAddress(true);
        const defaultOptions = {
          paramCart,
          immutableCategory: 9,
          currentValue: null,
          activePromocode: false,
          isPromoCodeEnabled: Boolean(Number(paramCart.promoShow)),
        };
        defaultOptions.paramCart.promoSum = promoSum;
        const state = { ...defaultOptions, ...param };
        const deliveryType = localStorage.getItem('deliverytype');
        state.isPromoCodeEnabled = (!!Number(state.paramCart.promoPersent) && !!state.paramCart.promoValue && !!Number(state.paramCart.promoSum)) ? state.isPromoCodeEnabled : false;
        state.immutableCategory = !excludeCategoryId ? state.immutableCategory : excludeCategoryId;
        state.activePromocode = !!((deliveryType === null || deliveryType === 'not delivery'));
        state.activePromocode = !state.isPromoCodeEnabled ? false : state.activePromocode;
        if (state.isPromoCodeEnabled && state.activePromocode) {
            showHidePromoCode(false);
        } else {
            showHidePromoCode(true);
        }
        if (state.isPromoCodeEnabled) {
            infoAlert.className = "text-center";
            infoAlert.innerHTML = '';
        }
        if (localStorage.getItem('cartItems') !== undefined && localStorage.getItem('cartItems') !== null && localStorage.getItem('cartItems') !== '') {
          cartTableBody.empty();
          const storageItem = localStorage.getItem('cartItems');
          try {
              products = JSON.parse(storageItem);
              if (products.length > 0) {
                  products = groupProducts(products, state);

                  const totalSum = products.map(({ total, count }) => total * count).reduce((acc, el) => acc + el, 0);
                  const totalDiscont = products.map(({ discont, count }) => discont * count).reduce((acc, el) => acc + el, 0);
                  initSum = products.map(({ price, count }) => price * count).reduce((acc, el) => acc + el, 0);
              products.forEach((element) => {
                addToCartTable(element);
              });
              // var sum = localStorage.getItem("countProductInCart");
              if (state.isPromoCodeEnabled) {
                if (deliveryType === 'delivery') {
                  if (initSum >= state.paramCart.promoSum) {
                    state.activePromocode = isPromocodeValid(state);
                    if (state.currentValue !== null && state.activePromocode) {
                      infoAlert.className = 'text-center alert alert-success';
                      infoAlert.textContent = `Промокод принят! - Скидка ${state.paramCart.promoPersent} %!`;
                    } else if (state.currentValue !== null && !state.activePromocode) {
                      infoAlert.className = 'text-center alert alert-danger';
                      infoAlert.textContent = 'Промокод не верен!';
                      valueInput.value = '';
                    }
                  }
                  if (initSum < state.paramCart.promoSum && isPromocodeValid(state)) {
                    infoAlert.className = 'text-center alert alert-warning';
                    infoAlert.textContent = `Промокод действителен от суммы ${state.paramCart.promoSum} руб!`;
                    valueInput.value = '';
                  }
                }
              }
              const sum = state.activePromocode ? totalSum : initSum;
              if (sum !== null) {
                cartTable.find('.text-right').find('h4').remove();
                const cartTableSum = cartTable.find('.checkout').find('span');
                cartTableSum.text(`${(Number(sum)).toFixed(2)} `);
                if (state.activePromocode) {
                  cartTable.find('.checkout').before(`<h4 class="text-secondary">Скидка: ${Number(totalDiscont).toFixed(2)} руб </h4>`);
                }
              }

              if ((localStorage.getItem('deliverytype') == undefined && localStorage.getItem('deliverytype') == null && localStorage.getItem('deliverytype') == '') || localStorage.getItem('deliverytype') == 'delivery') {
                $('#deliverytype2').prop('checked', true);
                showHideFormAddress(true);
              }
            }
          } catch (e) {
          }
        } else {
          cartTable.empty();
          cartTable.text('Корзина пуста');
        }
      }

    function initCart() {
        var storageItem = localStorage.getItem('cartItems');
        try {
            products = JSON.parse(storageItem);
            localStorage.setItem('cartItems', '');
            if(products.length > 0){
                cartWrapper.removeClass('empty');
                products.forEach(function(element) {
                    addToCart(element, false);
                });

                cartCount.find('li').eq(0).text(products.length);
                cartCount.find('li').eq(1).text(products.length+1);
            }

        }
        catch (e) {
        }
    }

    function toggleCart(bool) {
        var cartIsOpen = ( typeof bool === 'undefined' ) ? cartWrapper.hasClass('cart-open') : bool;

        if( cartIsOpen ) {
            cartWrapper.removeClass('cart-open');
            //reset undo
            clearInterval(undoTimeoutId);
            undo.removeClass('visible');
            cartList.find('.deleted').remove();

            setTimeout(function(){
                cartBody.scrollTop(0);
                //check if cart empty to hide it
                if( Number(cartCount.find('li').eq(0).text()) == 0) cartWrapper.addClass('empty');
            }, 500);
        } else {
            cartWrapper.addClass('cart-open');
        }
    }

    function addToCart(trigger, initCount) {
        var cartIsEmpty = cartWrapper.hasClass('empty');
        //update cart product list
        addProduct(trigger);

        if(initCount){
            //update number of items
            updateCartCount(cartIsEmpty);
        }
        //update total price
        updateCartTotal(trigger.price, true);
        //show cart
        cartWrapper.removeClass('empty');
    }

    function addToCartTable(trigger) {
        var productHtml = '<tr class="product" data-guid="'+trigger.guid+'" data-id="'+trigger.id+'" data-type="'+trigger.type+'" data-img="'+trigger.img+'" data-title="'+trigger.title+'" data-price="'+trigger.price+'" data-detail="'+trigger.detail+'"><td><a title="'+trigger.title+'" href="'+trigger.url+'"><img width="200px" src = "'+trigger.img+'" alt = "'+trigger.title+'" class = "rounded"></a></td><td><strong>'+trigger.title+'</strong><p>'+trigger.detail+'</p></td><td class="text-center"><div class="d-inline-block"><div class="btn-group" role="group"><button type="button" class="btn btn-outline-success btn-minus">-</button><div class="form-control-count"><span>'+trigger.count+'</span><input type="hidden" name="products[prod_'+trigger.id+'][type_'+trigger.type+']" value="'+trigger.count+'"></div><button type="button" class="btn btn-outline-success btn-plus">+</button></div></div></td><td class="price">'+trigger.price+' руб</td></tr>';
        var productAdded = $(productHtml);
        cartTableBody.prepend(productAdded);
    }

    function addProduct(trigger) {
        //this is just a product placeholder
        //you should insert an item with the selected product info
        //replace productId, productName, price and url with your real product info
        var productHtml = '<li class="product" data-id="'+trigger.guid+'"><div class="product-details"><h3>'+trigger.title+'</h3><span class="price">'+trigger.price+' руб</span><div class="clearfix"></div><div class="actions"><div>'+trigger.detail+'</div><a href="#0" class="delete-item">удалить</a></div></div></li>';
        var productAdded = $(productHtml);
        cartList.prepend(productAdded);

        //add product in local storage
        addProductInStorage(trigger);
    }

    function addProductInStorage(trigger) {
        var storageItem = localStorage.getItem('cartItems');
        if(storageItem === null)
        {
            products = [];
        }
        else
        {
            try {
                products = JSON.parse(storageItem);
            }
            catch (e) {
                products = [];
            }
        }
        products.push(trigger);

        localStorage.setItem('cartItems', JSON.stringify(products));
    }

    function addProductInCartTable(product){

        var input = product.find('input');
        var count = Number(input.val());
        count++;

        input.val(count);
        product.find('.form-control-count').text(count);

        var productTotPrice = Number(product.find('.price').text().replace('руб', ''));
        updateCartTotal(productTotPrice, true);

        var trigger = {
            id: product.data('id'),
            title: product.data('title'),
            type: product.data('type'),
            price: product.data('price'),
            detail: product.data('detail'),
            img: product.data('img'),
            url: product.data('url'),
            category: product.data('category'),
            count: 1,
            guid: getRandomArbitrary(100000, 900000)
        };
        //add product in local storage
        addProductInStorage(trigger);
        initTable();
    }

    function removeProduct(product) {
        clearInterval(undoTimeoutId);
        cartList.find('.deleted').remove();

        var topPosition = product.offset().top - cartBody.children('ul').offset().top ,
            productTotPrice = Number(product.find('.price').text().replace('руб', ''));

        product.css('top', topPosition+'px').addClass('deleted');

        //update items count + total price
        updateCartTotal(productTotPrice, false);
        updateCartCount(true, -1);
        undo.addClass('visible');

        //wait 8sec before completely remove the item
        undoTimeoutId = setTimeout(function(){
            undo.removeClass('visible');
            cartList.find('.deleted').remove();
        }, 8000);

        //remove product in local storage
        removeProductInStorage(product.data('id'));
    }

    function removeProductInStorage(productId){
        var storageItem = localStorage.getItem('cartItems');

        if(storageItem === null)
        {
            products = [];
        }
        else
        {
            try {
                products = JSON.parse(storageItem);
            }
            catch (e) {
                products = [];
            }

            if(Array.isArray(products) && products.length > 0)
            {
                products = products.filter(function(item) {
                    return item.guid !== productId;
                });
            }
        }

        if(products.length > 0)
        {
            localStorage.setItem('cartItems', JSON.stringify(products));
        }
        else
        {
            localStorage.setItem('cartItems', '');
        }
    }

    function removeProductInCartTable(product){

        var input = product.find('input');
        var count = Number(input.val());
        count--;

        input.val(count);
        product.find('.form-control-count').text(count);

        if(count === 0){
            $(product).remove();
        }

        var productTotPrice = Number(product.find('.price').text().replace('руб', ''));

        //update items count + total price
        updateCartTotal(productTotPrice, false);

        //remove product in local storage
        removeProductInStorage(product.data('guid'));
        initTable();
    }

    function quickUpdateCart() {
        var price = 0;

        cartList.children('li:not(.deleted)').each(function(){
            price = price + Number($(this).find('.price').text().replace('руб', ''));
        });

        cartTotal.text(price.toFixed(2));
    }

    function updateCartCount(emptyCart, quantity) {
        if( typeof quantity === 'undefined' ) {
            var actual = Number(cartCount.find('li').eq(0).text()) + 1;
            var next = actual + 1;

            if( emptyCart ) {
                cartCount.find('li').eq(0).text(actual);
                cartCount.find('li').eq(1).text(next);
            } else {
                cartCount.addClass('update-count');

                setTimeout(function() {
                    cartCount.find('li').eq(0).text(actual);
                }, 150);

                setTimeout(function() {
                    cartCount.removeClass('update-count');
                }, 200);

                setTimeout(function() {
                    cartCount.find('li').eq(1).text(next);
                }, 230);
            }
        } else {
            var actual = Number(cartBody.find('ul li').length) + quantity;
            var next = actual + 1;

            cartCount.find('li').eq(0).text(actual);
            cartCount.find('li').eq(1).text(next);
        }
    }

    function updateCartTotal(price, bool) {
        var textVar = Number(cartTotal.text());
        var priceVar = Number(price);
        var result = 0;

        if(bool) {
            result = textVar + priceVar;
        }
        else {
            result = textVar - priceVar;
        }
        cartTotal.text((result).toFixed(2));
        localStorage.setItem("countProductInCart", result);
    }

    function getRandomArbitrary(min, max) {
        var number = Math.random() * (max - min) + min;
        return parseInt(number);
    }

    function showHideFormAddress(flag) {
        if(flag){
            addressBox.show();
            $('#address').prop('required', true);
            localStorage.setItem("deliverytype" ,'delivery');
        }
        else{
            addressBox.hide();
            $('#address').prop('required', false);
            localStorage.setItem("deliverytype" ,'not delivery');
        }
    }


    function showHidePromoCode(flag) {
        if(flag){
            promoCode.show();
            // localStorage.setItem("deliverytype" ,'delivery');
        }
        else {
            promoCode.hide();
            // localStorage.setItem("deliverytype" ,'not delivery');
        }
    }

    function groupProducts(items, state) {
        const group = [];
        let flag = true;
        items.forEach((item) => {
          item.discont = Number(getDiscont(state, item.price, item.category));
          item.total = Number(item.price - item.discont);
          flag = false;
          group.forEach((element) => {
            if (item.id == element.id && element.type == item.type) {
              element.count = Number(element.count) + 1;
              flag = true;
            }
          });
          if (!flag) {
            group.push(item);
          }
        });
        return group;
      }

});

function getDiscont(...arr) {
    const [state, price, id] = arr;
    let result = 0;
    if (state.isPromoCodeEnabled && price > 0 && state.paramCart.promoPersent > 0) {
      result = Number(id) === Number(state.immutableCategory)
          ? 0
          : (Number(price) / 100) * Number(state.paramCart.promoPersent);
    }
    return Number(result).toFixed(2);
}

function isPromocodeValid(state) {
    if (!state.isPromoCodeEnabled) {
        return false;
    }
    return String(state.currentValue).toLocaleLowerCase().replace(/\s+/g, '') === String(state.paramCart.promoValue).toLocaleLowerCase().replace(/\s+/g, '');
}
