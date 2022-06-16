<div class="row">
		<div class="col-md-12">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				  <a class="navbar-brand" href="/"></a>
				  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				  </button>

				  <div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						@php($navs = \App\Http\Models\Nav::getNavbar())
					  	@foreach($navs as $nav)
							@if(count($nav->childs) == 0 || is_null($nav->childs))
								<li class="nav-item">
									<a class="nav-link" href="{{$nav->url}}">{{$nav->title}}</a>
								</li>

							@else
								<li class="nav-item dropdown">
									<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									  {{$nav->title}}
									</a>
									<div class="dropdown-menu" aria-labelledby="navbarDropdown">
										@foreach($nav->childs as $child)

											@if(!is_null($child->childs) && !empty($child->childs) && count($child->childs) > 0)
												<div class="dropdown dropright">
												  <a class="dropdown-item" href="#">{{$child->title}}</a>
												  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
													  @foreach($child->childs as $childchild)
															<a class="dropdown-item" href="{{$childchild->url}}">{{$childchild->title}}</a>
													  @endforeach
												  </div>
												</div>
											@else
												<a class="dropdown-item" href="{{$child->url}}">{{$child->title}}</a>
											@endif
										@endforeach
									</div>
								</li>
							@endif
						@endforeach
					</ul>
					  <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">

						<li class="nav-item">
							<?php $phone = \App\Http\Models\Settings::getValue('phone_delivery')?>
						  <a href="tel:<?=$phone?>" class="btn btn-outline-success"><?=$phone?></a>
						</li>
					  </ul>
				  </div>
				</nav>
		</div>
	</div>