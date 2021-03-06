<div class="row form-group">
<?php $key = isset($data['unique_id']) ? $data['key'] . '_' . $data['unique_id'] : $data['key'] ; ?>
	{{ html()->label($data['name'])->class('col-md-2 form-control-label')->for($key) }}
	<div class="col-md-10">
		<div class="custom-control custom-switch">
		<?php $input = html()
		->input()
		->type('checkbox')
		->value('1')
		->attribute('id', $key)
		->class('custom-control-input');
		if($data['required']){
			$input = $input->required();
		}
		if($asset_classname){
			$name = 'assetInjectionform[' . $asset_classname . '][' . $data['unique_id'] . '][' . $data['key'] . ']';
		}else{
			$name = $data['key'];
		}

		$name .= (isset($multiform) && $multiform) ? '[]' : '';?>

		{{ $input->name($name)->checked(old($name, !empty($data['value']) ? true: false)) }}

		<label class="custom-control-label" for="{{ $key }}">
	</div>

		<?php if ($data['help']): ?>
			<small class="help-block form-text text-muted"><?php echo $data['help']; ?></small>
		<?php endif; ?>
	</div>
</div>
