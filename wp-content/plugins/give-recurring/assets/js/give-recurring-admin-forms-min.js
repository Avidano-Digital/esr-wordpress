var Give_Recurring_Vars;jQuery(document).ready(function($){var e={init:function(){e.recurring_option=$("select#_give_recurring"),e.row_recurring_period=$(".give-recurring-period"),e.row_recurring_times=$(".give-recurring-times"),e.toggle_set_recurring_fields(),e.toggle_multi_recurring_fields(),e.recurring_repeatable_select(),e.validate_times(),e.validate_period(),e.detect_email_access(),$('input[name="_give_price_option"]').on("change",function(){"set"==$('input[name="_give_price_option"]:checked').val()?e.toggle_set_recurring_fields():e.toggle_multi_recurring_fields()}),$("select#_give_recurring").on("change",function(){"set"==$('input[name="_give_price_option"]:checked').val()?e.toggle_set_recurring_fields():e.toggle_multi_recurring_fields()})},toggle_set_recurring_fields:function(){var i=e.recurring_option.val();if("set"!==$('input[name="_give_price_option"]:checked').val())return!1;"yes_admin"==i?($(".give-recurring-row.give-hidden").show(),$(".give-recurring-checkbox-option").hide()):"yes_donor"==i?($(".give-recurring-row.give-hidden").show(),$(".give-recurring-checkbox-option").show()):$(".give-recurring-row.give-hidden").hide()},toggle_multi_recurring_fields:function(){var i=$('input[name="_give_price_option"]:checked').val(),r=e.recurring_option.val();if("multi"!==i)return!1;"yes_admin"==r?($(".give-recurring-row.give-hidden").hide(),$(".give-recurring-multi-el").show(),$('select[name$="[_give_recurring]"]').change(),$(".cmb-type-levels-repeater-header, #_give_donation_levels_repeat").addClass("give-recurring-admin-choice")):"yes_donor"==r?($(".give-recurring-row.give-hidden").show(),$(".give-recurring-multi-el").hide()):"no"==r&&($(".give-recurring-row.give-hidden").hide(),$(".give-recurring-multi-el").hide(),$(".cmb-type-levels-repeater-header, #_give_donation_levels_repeat").removeClass("give-recurring-admin-choice"))},update_recurring_fields:function(e){var i=$("option:selected",e).val(),r=e.parents(".cmb-repeatable-grouping").find('select[name$="[_give_period]"], input[name$="[_give_times]"]');"no"==i?r.attr("disabled",!0):r.attr("disabled",!1),e.attr("disabled",!1)},recurring_repeatable_select:function(){$("body").on("change",'select[name$="[_give_recurring]"]',function(){e.update_recurring_fields($(this))}),$('select[name$="[_give_recurring]"]').change(),$("body").on("cmb2_add_row",function(){$('select[name$="[_give_recurring]"]').each(function(i,r){e.update_recurring_fields($(this))})})},validate_times:function(){$(".give-time-field").on("blur",function(){var e=$(this).val();if("no"==$("#_give_recurring").val())return!1;void 0!==Give_Recurring_Vars.enabled_gateways.paypal&&1==e&&(alert(Give_Recurring_Vars.invalid_time.paypal),$(this).focus())})},validate_period:function(){$(".give-period-field").on("blur",function(){var e=$(this).val();if("no"==$("#_give_recurring").val())return!1;void 0!==Give_Recurring_Vars.enabled_gateways.wepay&&"day"==e&&(alert(Give_Recurring_Vars.invalid_period.wepay),$(this).val("week"),$(this).focus())})},detect_email_access:function(){"on"!==Give_Recurring_Vars.email_access&&"no"!==Give_Recurring_Vars.recurring_option&&e.toggle_login_message("on"),$("select#_give_recurring").on("change",function(){"no"!==$(this).val()?e.toggle_login_message("on"):e.toggle_login_message("off")})},toggle_login_message:function(e){"on"==e&&0==$(".login-required-td").length?($(".cmb2-id--give-logged-in-only, .cmb2-id--give-show-register-form .cmb-td").hide(),$(".cmb2-id--give-show-register-form").addClass("recurring-email-access-message"),$(".cmb2-id--give-show-register-form .cmb-td").before(Give_Recurring_Vars.messages.login_required),$("#_give_logged_in_only").prop("checked",!1)):"off"==e&&($(".cmb2-id--give-logged-in-only, .cmb2-id--give-show-register-form .cmb-td").show(),$(".cmb2-id--give-show-register-form").removeClass("recurring-email-access-message"),$(".login-required-td").remove())}};e.init()});