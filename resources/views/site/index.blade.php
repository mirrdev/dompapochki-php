@extends('layouts.site')
@section('title', $seo['title'])
@section('description',$seo['description'])
@section('main-content')

	@if($settings['homepage_slider_show'] == 1 && isset($slides) && count($slides)>0)
    <div class="row">
		<div class="col-md-12">
			<div class="carousel slide" id="carousel-297623">
				<ol class="carousel-indicators">
					<?php $i=0; ?>
					@foreach($slides as $slide)
						<li data-slide-to="<?=$i?>" data-target="#carousel-"<?=$i?> class="@if($i==0) active @endif"></li>
						<?php $i++; ?>
					@endforeach
				</ol>
				<div class="carousel-inner">
					<?php $i=0; ?>
					@foreach($slides as $slide)
						<div class="carousel-item @if($i==0) active @endif">
							<img class="d-block w-100" alt="{{$slide->title}}" src="{{$slide->filepath}}">
							@if(!empty($slide->title) && !is_null($slide->title))
								<div class="carousel-caption">
									@if(!empty($slide->title) && !is_null($slide->title))
										<h4>
											{{$slide->title}}
										</h4>
									@endif
									@if(!empty($slide->description) && !is_null($slide->description))
										<p>
											{{$slide->description}}
										</p>
									@endif
								</div>
							@endif
						</div>
                        <?php $i++; ?>
					@endforeach

				</div>
				<a class="carousel-control-prev" href="#carousel-297623" data-slide="prev"><span class="carousel-control-prev-icon"></span> <span class="sr-only">Previous</span></a> <a class="carousel-control-next" href="#carousel-297623" data-slide="next"><span class="carousel-control-next-icon"></span> <span class="sr-only">Next</span></a>
			</div>
		</div>
	</div>
	@endif

    @if(isset($categories) && count($categories)>0)
        <section class = "section-product-categories">
            <h2 class = "section-title text-danger">{{$settings['homepage_header_section_product_categories']}}</h2>
            <div class="row">
                <?php $i=0; ?>
                @foreach($categories as $category)
                    <?php $i++; ?>
                    <div class = "@if($i > 2) col-md-4 @else col-md-6 @endif">
                        <div class = "category @if($i > 2) small @endif">
                             <a href = "{{route('category', ['category' => $category->slug])}}">
                                 <img src = "{{$category->filepath}}" alt = "{{$category->title}}">
                                 <div class = "caption">
                                     <h4>{{$category->title}}</h4>
                                 </div>
                             </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

	@if(isset($settings['homepage_delivery_map']))
		<div class="row">
			<div class="col-md-12">
				<h3 class="text-danger">{{$settings['homepage_delivery_title']}}</h3>
				{!! $settings['homepage_delivery_map'] !!}
			</div>
		</div>
	@endif

	@if(isset($settings['homepage_payment_information']))
		<hr>
		<div class="row">
			<div class="col-md-12">
				{!! $settings['homepage_payment_information'] !!}
			</div>
		</div>
	@endif

@endsection
