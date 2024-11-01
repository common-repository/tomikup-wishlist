jQuery(document).ready(function () {
	jQuery('.show-more').on('click', function (e) {
		e.preventDefault();
		jQuery('.more-options').toggleClass('active');
		jQuery(this).toggleClass('active');
	});

	jQuery('input[name=fixed]').on('change', function (e) {
		var tmkStatus = jQuery('input[name=tmk-status]:checked').val();

		if (jQuery(this).val() == 'false' && tmkStatus == 'tmk-status-fixed') {
			changeTmkStatus('tmk-status-custom', false);
		}
	});

	jQuery('input[name=tmk-status]').on('change', function (e) {
		// console.log(jQuery(this).val());

		if (jQuery(this).val() == 'tmk-status-fixed') {
			jQuery('label[for=positionFixed]').click();
		} else {
			jQuery('label[for=positionStatic]').click();
		}

		tmkShowCodes(jQuery(this).val());
	});
});

function tmkShowCodes(status) {
	var allowCodes = ['tmk-status-custom', 'tmk-status-off'];
	var hideCodes = true;
	for (let index = 0; index < allowCodes.length; index++) {
		var code = allowCodes[index];
		if (status == code) {
			hideCodes = false;
		}
	}

	if (hideCodes) {
		jQuery('.raw-code').addClass('hide-it');
		jQuery('.raw-code-alert').removeClass('hide-it');
	} else {
		jQuery('.raw-code').removeClass('hide-it');
		jQuery('.raw-code-alert').addClass('hide-it');
	}
}

function changeTmkStatus(toStatus, event) {
	if (event) event.preventDefault();

	jQuery('input[name=tmk-status][value=' + toStatus + ']').prop('checked', true);
	tmkShowCodes(toStatus);
}
