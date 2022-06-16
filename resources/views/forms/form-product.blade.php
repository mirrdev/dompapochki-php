@extends('layouts.master')
@section('before-css')


@endsection

@section('main-content')
           <div class="breadcrumb">
                <h1>@lang('panel.product.create')</h1>
                <ul>
                    <li><a href="{{route('products')}}">@lang('panel.product.header')</a></li>
                    <li>@lang('panel.create')</li>
                </ul>
            </div>

            <div class="separator-breadcrumb border-top"></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    @lang('panel.forms.errors')
                                </div>
                            @endif
                            <div class="card-title">Заполните все обязательные поля</div>
                            <form class="needs-validation" novalidate method="post" action="{{$route}}">
                                @csrf
                                <div class="form-row mb-2">
                                    <!-- Title Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="title">@lang('panel.product.fields.title')</label>
                                        <input type="text" class="form-control" name="title" id="title" placeholder="@lang('panel.product.fields.title')" value="{{old('title', $item['title'])}}" required>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                        @if ($errors->has('title'))
                                            <br>
                                            <div class="alert alert-danger">
                                                <span>{{ $errors->first('title') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Slug Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="title">@lang('panel.product.fields.slug')</label>
                                        <input type="text" class="form-control" name="slug" id="slug" placeholder="@lang('panel.product.fields.slug')" value="{{old('slug', $item['slug'])}}" required>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                        @if ($errors->has('slug'))
                                            <br>
                                            <div class="alert alert-danger">
                                                <span>{{ $errors->first('slug') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Description Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="description">@lang('panel.product.fields.description')</label>
                                        <textarea type="text" class="form-control" name="description" id="description" placeholder="@lang('panel.product.fields.description')" required>{{old('description', $item['description'])}}</textarea>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                        @if ($errors->has('description'))
                                            <br>
                                            <div class="alert alert-danger">
                                                <span>{{ $errors->first('description') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Filepath Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="name">@lang('panel.product.fields.filepath')</label>
                                        <div>
                                            <button data-input="thumbnail" data-preview="holder" class="btn btn-primary upload-btn">
                                               <i class="fa fa-picture-o"></i> @lang('panel.select.image')
                                            </button>
                                        </div>
                                        <input id="thumbnail" type="hidden" class="form-control" name="filepath" id="filepath" placeholder="@lang('panel.product.fields.filepath')" value="{{old('filepath', $item['filepath'])}}" required>
                                        <div id="holder" style="margin-top:15px;max-height:100px;">
                                            @if(isset($item->filepath))
                                                <img height="100px" src="{{$item->filepath}}"/>
                                            @endif
                                        </div>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                        @if ($errors->has('filepath'))
                                            <br>
                                            <div class="alert alert-danger">
                                                <span>{{ $errors->first('filepath') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    @php($categories = \App\Http\Models\Category::getAll())
                                    <!-- Category Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="text">@lang('panel.product.fields.category')</label>
                                        <select name="category_id" class="form-control">
                                            @foreach($categories as $category)
                                                <option <?= ($category['id'] == $item->category_id)?'selected = "selected"':'' ?> value = "{{old('category_id', $category['id'])}}">{{$category['title']}}</option>
                                            @endforeach
                                        </select>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                        @if ($errors->has('category_id'))
                                            <br>
                                            <div class="alert alert-danger">
                                                <span>{{ $errors->first('category_id') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <hr>
                                    <?php for($i=1; $i<4; $i++) {?>
                                        <!-- <?='Name'.$i?> Field -->
                                        <div class="col-md-12 mb-3">
                                            <label for="title">@lang('panel.product.fields.name'.$i)</label>
                                            <input type="text" class="form-control" name="<?='name'.$i?>" id="<?='name'.$i?>" placeholder="@lang('panel.product.fields.name'.$i)" value="{{old('name'.$i, $item['name'.$i])}}">
                                            <div class="valid-tooltip">
                                                @lang('panel.message.valid')
                                            </div>
                                            <div class="invalid-tooltip">
                                                @lang('panel.message.invalid')
                                            </div>
                                            @if ($errors->has('name'.$i))
                                                <br>
                                                <div class="alert alert-danger">
                                                <span>{{ $errors->first('name'.$i) }}</span>
                                            </div>
                                            @endif
                                        </div>
                                        <!-- <?='Detail'.$i?> Field -->
                                        <div class="col-md-12 mb-3">
                                            <label for="title">@lang('panel.product.fields.detail'.$i)</label>
                                            <input type="text" class="form-control" name="<?='detail'.$i?>" id="<?='detail'.$i?>" placeholder="@lang('panel.product.fields.detail'.$i)" value="{{old('detail'.$i, $item['detail'.$i])}}">
                                            <div class="valid-tooltip">
                                                @lang('panel.message.valid')
                                            </div>
                                            <div class="invalid-tooltip">
                                                @lang('panel.message.invalid')
                                            </div>
                                            @if ($errors->has('detail'.$i))
                                                <br>
                                                <div class="alert alert-danger">
                                                <span>{{ $errors->first('detail'.$i) }}</span>
                                            </div>
                                            @endif
                                        </div>
                                        <!-- <?='Price'.$i?> Field -->
                                        <div class="col-md-12 mb-3">
                                            <label for="title">@lang('panel.product.fields.price'.$i)</label>
                                            <input type="text" class="form-control" name="<?='price'.$i?>" id="<?='price'.$i?>" placeholder="@lang('panel.product.fields.price'.$i)" value="{{old('price'.$i, $item['price'.$i])}}" <?=($i==1)?'required':''?>>
                                            <div class="valid-tooltip">
                                                @lang('panel.message.valid')
                                            </div>
                                            <div class="invalid-tooltip">
                                                @lang('panel.message.invalid')
                                            </div>
                                            @if ($errors->has('price'.$i))
                                                <br>
                                                <div class="alert alert-danger">
                                                <span>{{ $errors->first('price'.$i) }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    <?php } ?>
                                    <hr>

                                    @php($labels = \App\Http\Models\Product::getLabels())
                                    <!-- Label Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="text">@lang('panel.product.fields.label.title')</label>
                                        <select name="label" class="form-control">
                                            @foreach($labels as $label)
                                                <option <?= ($label['id'] == $item->label)?'selected = "selected"':'' ?> value = "{{old('label', $label['id'])}}">{{$label['title']}}</option>
                                            @endforeach
                                        </select>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                        @if ($errors->has('label'))
                                            <br>
                                            <div class="alert alert-danger">
                                                <span>{{ $errors->first('label') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Text Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="text">@lang('panel.product.fields.text')</label>
                                        <textarea type="text" class="form-control editor" name="text" id="text" placeholder="@lang('panel.product.fields.text')" required>{{old('text', $item['text'])}}</textarea>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                        @if ($errors->has('text'))
                                            <br>
                                            <div class="alert alert-danger">
                                                <span>{{ $errors->first('text') }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Status Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="text">@lang('panel.product.fields.status.title')</label>
                                        <label class="radio radio-primary">
                                            <input type="radio" name="status" value=1 formcontrolname="radio" @if($item->status == 1) checked @endif>
                                            <span>@lang('panel.product.fields.status.on')</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio radio-primary">
                                            <input type="radio" name="status" value=0 formcontrolname="radio" @if($item->status == 0) checked @endif>
                                            <span>@lang('panel.product.fields.status.off')</span>
                                            <span class="checkmark"></span>
                                        </label>
                                        <div class="valid-tooltip">
                                            @lang('panel.message.valid')
                                        </div>
                                        <div class="invalid-tooltip">
                                            @lang('panel.message.invalid')
                                        </div>
                                        @if ($errors->has('status'))
                                            <br>
                                            <div class="alert alert-danger">
                                                <span>{{ $errors->first('status') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <label for="title">@lang('panel.seo.header')</label>
                                    <!-- SEO Title Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="titleSEO">@lang('panel.seo.title')</label>
                                        <input type="text" class="form-control" id="titleSEO" name="seo[title]" placeholder="@lang('panel.seo.title')" value="{{$seo->title}}">
                                    </div>
                                    <!-- SEO Description Field -->
                                    <div class="col-md-12 mb-3">
                                        <label for="textSEO">@lang('panel.seo.description')</label>
                                        <textarea class="form-control" id="textSEO" name="seo[description]" placeholder="@lang('panel.seo.description')">{{$seo->description}}</textarea>
                                    </div>
                                </div>
                                <button class="btn btn-primary" type="submit">@lang('panel.save')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

@endsection

@section('page-js')




@endsection

@section('bottom-js')

 <script src="{{asset('assets/js/form.validation.script.js')}}"></script>
 <script>$('.upload-btn').filemanager('image');</script>

@endsection
