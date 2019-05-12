@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . $asset->name . ' | ' . __('phpsa-datastore::backend.titles.create'))

@section('content')
	{{ html()->form('POST', route('admin.ams.content.save', $asset->urlPath()))->id('create-asset-form')->class('form-horizontal')->open() }}
	<input type="hidden" name="id" id="asset_id" value="{{ $asset->id }}" />
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-5">
                        <h4 class="card-title mb-0">
                            @lang('phpsa-datastore::backend.labels.content.list')
                            <small class="text-muted">@lang($asset->id ? 'buttons.general.crud.update' : 'phpsa-datastore::backend.labels.content.create') <strong>{{ $asset->name }}</strong></small>
                        </h4>
                    </div><!--col-->
                </div><!--row-->

                <hr>

                <div class="row mt-4 mb-4">
                    <div class="col">
							<ul class="nav nav-tabs" id="amsTab" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ $asset->name }}</a>
									</li>


									<?php if ($parents): ?>
										<?php foreach ($parents as $pid => $parent): ?>
										<li class="nav-item">
												<a class="nav-link" id="parent_{{ $pid }}_tab" data-toggle="tab"  href="#parent_{{ $pid }}" aria-controls="parent_{{ $pid }}_tab" aria-selected="false"><?php echo $parent['name']; ?></a>
											</li>
										<?php endforeach; ?>
									<?php endif; ?>

								<?php if ($children): ?>

									<li class="nav-item ">
											<a class="nav-link" id="{{$children['path']}}-child-tab" data-toggle="tab"  href="#{{$children['path']}}-child" role="tab" aria-controls="<?php echo $children['path']; ?>-child" aria-selected="false">{{ $children['name'] }}</a>
									</li>

								<?php endif; ?>


								<?php  if ($asset->getMetadataForm()): ?>
									<li class="nav-item">
											<a class="nav-link" id="seo-tab" data-toggle="tab" href="#seo" role="tab" aria-controls="seo" aria-selected="false">@lang('phpsa-datastore::backend.labels.tabs.seo')</a>
										</li>
									<li class="nav-item">
										<a class="nav-link" id="cssjs-tab" data-toggle="tab" href="#cssjs" role="tab" aria-controls="cssjs" aria-selected="false">@lang('phpsa-datastore::backend.labels.tabs.cssjs')</a>
									</li>
								<?php endif ;?>
							</ul>

							<div class="tab-content tab-validate" id="amsTabContent">
									<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
											<fieldset>
													<h6>{{ $asset->name }}<small> - @lang('phpsa-datastore::backend.labels.tabs.label.createmodifyasset')</small></h6>
													<hr />
													{!!  $asset->getForm() !!}

												</fieldset>

									</div>



									<?php if ($parents): ?>
										<?php foreach ($parents as $parent): ?>
										<div class="tab-pane fade" id="parent_{{ $pid }}" role="tabpanel" aria-labelledby="<parent_{{ $pid }}_tab">


												<fieldset>
														<h6>{{ $parent['name'] }}<small> - Your {{ $asset->name }} has the following {{ Str::plural($parent['name']) }}</small></h6>
														<hr />
												<?php if ($parent['related']): ?>


															<?php foreach ($parent['related'] as $k => $v): ?>

															<div class="form-check form-check-inline mr-3">
																<input class="form-check-input" id="parent_{{ $pid }}_{{ $k }}" type="<?php echo ((int)$v['accept_limit'] === 1 ? 'radio' : 'checkbox'); ?>" name="related_assets[]" value="<?php echo $v['id']; ?>" <?php echo (isset($v['assigned_and_found']) && $v['assigned_and_found']) ? ' checked="checked"' : ''; ?>/>
																<input name="related_id[]" type="hidden" value="<?php echo $v['id']; ?>" />
																<label class="form-check-label" for="parent_{{ $pid }}_{{ $k }}"><?php echo $v['value']; ?></label>
															</div>


															<?php endforeach; ?>

													<?php endif; ?>

												</fieldset>
											</div>

										<?php endforeach; ?>
									<?php endif; ?>



									<?php if ($children): ?>

										<div class="tab-pane fade" id="{{$children['path']}}-child" role="tabpanel" aria-labelledby="{{$children['path']}}-child-tab">
											<div class="row">
												<div class="col-md-12">
														<h6 class="mb-4">{{ $children['name'] }}<small> - @lang('phpsa-datastore::backend.labels.tabs.label.createmodifyasset')</small>

															<div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
																	<a id="addChild" href="#" class="btn btn-success ml-1" data-toggle="tooltip" title="Add <?php echo ucwords($children['path']); ?>"><i class="fas fa-plus-circle"></i></a>
																</div><!--btn-toolbar-->

															</h6>
														<hr />
												</div>
												<div class="col-2">
														<div id="child-pills" class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
															<?php foreach ($children['kids'] as $idx => $child): ?>
																<a data-count="{{ $idx + 1 }}" class="child-tab nav-link<?php echo $idx === 0 ? ' active' : ''; ?>" id="v-pills-{{ $idx }}-tab" data-toggle="pill" href="#v-pills-{{ $idx }}" role="tab" aria-controls="v-pills-{{ $idx }}" aria-selected="true" data-type="<?php echo $children['path']; ?>" data-count="<?php echo ($idx + 1); ?>" data-label="<?php echo ucwords($children['path']); ?>"><?php echo ucwords($children['path']) . ' ' . ($idx + 1); ?></a>
															<?php endforeach; ?>



														</div>
												</div>
												<div class="col-10">

														<div class="tab-content tab-validate border-0" id="v-pills-tabContent">
																<?php foreach ($children['kids'] as $idx => $child): ?>
																	<div class="child-tab-pane tab-pane fade<?php echo $idx == 0 ? ' show active' : '';?>" id="v-pills-{{ $idx }}" role="tabpanel" aria-labelledby="v-{{ $idx }}-home-tab">
																			<fieldset>
																					<h6><span><?php echo ucwords($children['path']) . ' ' . ($idx + 1); ?></span>
																						<div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
																						<a <?php echo (count($children['kids']) < 2) ? 'style="display:none;" ' : ''; ?>class="remove-child btn btn-danger" data-target="#v-pills-{{ $idx }}" data-count="<?php echo $idx + 1; ?>">Remove <?php echo ucwords($children['path']) . ' ' . ($idx + 1); ?></a>
																						</div>
																					</h6>
																					<hr />
																					<div style="position:relative">
																						<div class="child-asset-form-container">
																							<?php echo $child->injectForm($idx + 1); ?>
																						</div>
																						<div style="z-index:999;display:none;background:#cd5c5c;opacity:0.7;position:absolute;top:0;width:100%;height:100%" class="child-mask"></div>
																					</div>
																			</fieldset>
																	</div>
																<?php endforeach ;?>

														</div>




												</div>
											</div>
										</div>
									<?php endif; ?>


									<?php  if ($asset->getMetadataForm()): ?>
									<div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
											<fieldset>
													<h6>@lang('phpsa-datastore::backend.labels.tabs.page')<small> - @lang('phpsa-datastore::backend.labels.tabs.label.createmodifyseo')</small></h6>
													<hr />

													<div class="row form_group mb-3">
														{{ html()->label('Page Title')->class('col-md-2 form-control-label')->for('pageTitle') }}
														<div class="col-md-10">

															{{ html()
															->text('page_title')
															->placeholder('Title of the Page')
															->attribute('id', 'pageTitle')
															->class('form-control')
															->value(!empty($pageData) ? $pageData->title : NULL)
															->required()
															}}
														</div>
													</div>

													<div class="row form_group mb-3">
															{{ html()->label('Page Link')->class('col-md-2 form-control-label')->for('pageSlug') }}
															<div class="col-md-10">

																{{ html()
																->text('page_slug')
																->placeholder('Title of the Page')
																->attribute('id', 'pageSlug')
																->attribute('maxlength', "70")
																->value(!empty($pageData) ? $pageData->slug : NULL)
																->attribute('pattern' ,"[-a-zA-Z0-9]*")
																->attribute('data-auto-title', ! empty($page_data) && ! empty($page_data->slug) ? 'disallow' : 'allow')
																->class('form-control')
																->required()
																}}
																<small class="help-block form-text text-muted">This is the URL that will appear in the browser location bar.</small>
																	<div id="go" style="display: none;" class="alert-box success">
																		<p><strong>URL Available</strong> This URL is valid.</p>
																	</div>
																	<div id="halt" style="display: none;" class="alert-box alert error">
																		<p><strong>Try again</strong> This URL is currently in use.</p>
																	</div>
															</div>
														</div>
												</fieldset>
												<fieldset>
														<h6>@lang('phpsa-datastore::backend.labels.tabs.seo')<small> - @lang('phpsa-datastore::backend.labels.tabs.label.createmodifyseometa')</small></h6>
														<hr />
														{!! $asset->getMetadataForm() !!}
												</fieldset>

									</div>
									<div class="tab-pane fade" id="cssjs" role="tabpanel" aria-labelledby="cssjs-tab">
											<fieldset>
													<h6>@lang('phpsa-datastore::backend.labels.tabs.cssjs')<small> - @lang('phpsa-datastore::backend.labels.tabs.label.createmodifycssjs')</small></h6>
													<hr />
											{!! $asset->getDeveloperForm() !!}
										</fieldset>
									</div>
								<?php endif; ?>
								  </div>





                    </div><!--col-->
                </div><!--row-->
            </div><!--card-body-->

            <div class="card-footer clearfix">
                <div class="row">
                    <div class="col">
                        {{ form_cancel(route('admin.ams.content.list', $asset->urlPath()), __('buttons.general.cancel')) }}
                    </div><!--col-->

                    <div class="col text-right">
                        {{ form_submit($asset->id ? __('buttons.general.crud.update') : __('buttons.general.crud.create')) }}
                    </div><!--col-->
                </div><!--row-->
            </div><!--card-footer-->
        </div><!--card-->
    {{ html()->form()->close() }}
@endsection

@push('after-scripts')
{!! script('https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.17.0/trumbowyg.min.js') !!}
{!! script('https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.17.0/plugins/cleanpaste/trumbowyg.cleanpaste.min.js') !!}
{!! script('https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.17.0/plugins/cleanpaste/trumbowyg.pasteimage.min.js') !!}
{!! script('https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.17.0/plugins/base64/trumbowyg.base64.min.js') !!}
<script>
//htmlEditor
$('.ams-htmleditor').trumbowyg();

//Autocomplete
<?php if(empty($asset->id)): ?>
	var timedCall = false;
	$(document).on('keyup', '#pageTitle', function() {
		if(timedCall) clearTimeout(timedCall);
		var pageTitle = $(this).val()
		timedCall = setTimeout(function() {
			$.get('{{ route('admin.ams.content.slug')}}?generate=1&id={{ $asset->id }}&page_slug=' + pageTitle)
			.then(function(response) {
				$('#pageSlug').val(response.slug);
				validator.element( "#pageSlug" );
			});
		}, 350);

	});
<?php endif; ?>



//form Validation
var validator = $('#create-asset-form').validate({
	ignore: [
		'.no-validate'
	],
	invalidHandler: function() {

	//	$(this).find('input[type="submit"]').attr('disabled', true);
	//    $(this).find('button[type="submit"]').attr('disabled', true);
		var submits = $(this).find('[type="submit"]');
            setTimeout(function() {
				submits.attr('disabled', false);
                $('.nav-tabs a strong.required').remove();
                var validatePane = $('.tab-content.tab-validate .tab-pane:has(input.is-invalid)').each(function() {
                    var id = $(this).attr('id');
					$('.nav-tabs,.nav-pills').find('a[href^="#' + id + '"]').append(' <strong class="required text-danger">***</strong> ');

                });
            });
		},
	errorElement: "em",
	errorPlacement: function errorPlacement(error, element) {
		error.addClass("invalid-feedback");
		if (element.prop("type") === "checkbox") {
		error.insertAfter(element.parent("label"));
		} else {
		error.insertAfter(element);
		}
	},
	highlight: function highlight(element) {
		$(element)
		.addClass("is-invalid")
		.removeClass("is-valid");
	},
	unhighlight: function unhighlight(element) {
		$(element)
		.addClass("is-valid")
		.removeClass("is-invalid");
	},
	rules: {
		page_slug : {
			required: true,
			remote: {
				url:  '{{ route('admin.ams.content.slug') }}',
				data: {
					id: function() {
						return $('#asset_id').val()
					}
				}
			}
		}
	}
});


$('#addChild').click(function () {
        var idx = Number($('a.child-tab:last').attr('data-count'));
        var counter = idx + 1;
		var label = $('a.child-tab:last').attr('data-label') + ' ' + counter;

		$('a.remove-child').show();
		$('#addChild').hide();

		var childPill = $('a.child-tab:last').clone();
		childPill.attr('data-count', counter)
		.attr('id', 'v-pills-' + counter + '-tab')
		.attr('aria-controls' , 'v-pills-' + counter)
		.attr('href', '#v-pills-' + counter )
		.removeClass('active')
		.text(label);

		$('#child-pills').append(childPill);

		var childTab = $('.child-tab-pane:last').clone();
		childTab.attr('id','v-pills-' + counter)
		.attr('ria-labelledby', 'v-' + counter + '-home-tab')
		.removeClass('active');

		childTab.find('h6').find('span').text($('a.child-tab:last').attr('data-label') + ' ' + counter);
		childTab.find('h6').find('a')
		.attr('data-target', '#v-pills-' + counter)
		.attr('data-count', counter)
		.text('Remove ' + $('a.child-tab:last').attr('data-label') + ' ' + counter);

		childTab.find('.child-asset-form-container').empty()

		$('.child-tab-pane:last').after(childTab);


		childTab.find('.child-asset-form-container').load('{{ route('admin.ams.content.inject')}}?asset=' + $('a.child-tab:last').attr('data-type') + '&idx=' + counter, function() {
			childPill.trigger("click");
			childTab.find('.ams-htmleditor').trumbowyg();
			$('#addChild').show();
		});

	return false
});

$(document).on("click", 'a.remove-child', function () {
        var count = $(this).attr('data-count');
        var tab = $(this).attr('data-target');
        // if it is not green, do this
        if (!$(this).hasClass('btn-success')) {
            $(tab).find('div.child-mask').show();
            $(tab).find('.asset-injector-input').attr('name', $(tab).find('.asset-injector-input').attr('name').replace('assetInjectionform', 'assetRemove'));
            $('a.child-tab[data-count=' + count + ']').addClass('removed');
            $(this).addClass('btn-success').removeClass('btn-danger').text($(this).text().replace('Remove', 'Restore'));
            if ($('a.child-tab').not('.removed').length <= 1) {
                $('a.remove-child').not('.btn-success').hide();
            }
        } else {
            $(tab).find('div.child-mask').hide();
            $(tab).find('.asset-injector-input').attr('name', $(tab).find('.asset-injector-input').attr('name').replace('assetRemove', 'assetInjectionform'));
            $('a.child-tab[data-count=' + count + ']').removeClass('removed');
            $(this).removeClass('btn-success').addClass('btn-danger').text($(this).text().replace('Restore', 'Remove'));
            $('a.remove-child').show();
        }
        return false;
    });

	$(document).on("click", ".ams-upload-button, .ams-upload-filename", function() {
		var target = $(this).data('target');
		console.log(target, $(target), $(target).first());
		$(target).trigger("click");
	});

	$(document).on('keydown', '.ams-upload-filename', function(e) {
		e.preventDefault();
		e.stopPropagation();
		return false;
	})

	$(document).on("change", ':file', function() {
		var file = this.files[0];
		var data = new FormData();
		var target = $(this).attr('id') + '_file';
		data.append("file", file);
		data.append("_token" ,"{{ csrf_token() }}");

		$.ajax({
    // Your server script to process the upload
    url: '{{ route('admin.ams.content.file') }}',
    type: 'POST',

    // Form data
    data: data,

    // Tell jQuery not to process data or worry about content-type
    // You *must* include these options!
    cache: false,
    contentType: false,
    processData: false,

    // Custom XMLHttpRequest
    xhr: function () {
      var myXhr = $.ajaxSettings.xhr();
      if (myXhr.upload) {
        // For handling the progress of the upload
        myXhr.upload.addEventListener('progress', function (e) {
          if (e.lengthComputable) {
            $('progress').attr({
              value: e.loaded,
              max: e.total,
            });
          }
        }, false);
      }
      return myXhr;
    },
	success: function(res) {
		$('#' + target).val(res.file);
	}
  });
	});



	</script>
@endpush

@push('after-styles')
{{  style('https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.17.0/ui/trumbowyg.min.css')  }}

@endpush