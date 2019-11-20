"use strict";

/**
* String of characters that are not allowed in input from the user.
* @type {String}
*/
const invalidChars = "<>!#$%^&*+[]{}?:;|'\"\\/~`=";

$(document).ready(function() {
  // Every submit button gets disabled after clicked
  // so the form is not submitted multiple times in case
  // the user clicks multiple times.
  $(this).submit(function() {
    $("button[type='submit']", this)
      .text("Please Wait...")
      .prop('disabled', 'true');
    return true;
  });

  resetHandlers();
  assignHandlers();
});

/**
 * Enclosing method of all handlers to be (re)assigned to the new dynamically
 * created inputs.
 */
function assignHandlers() {
  assignInvalidCharHandlers();
  assignIBANHandlers();
  assignInvalidNumbersHandlers();
}

/**
 * Removes all handlers from these specific inputs:
 *  1:  $("input[type='text']").off("keyup")
 *  2:  $("input[name^='iban']").off("keyup")
 *  3:  $("input[type='number']").off("keyup")
 *  4:  $("input[type='number']").off("focusout")
 */
function resetHandlers() {
  $("input[type='text']").off("keyup");
  $("input[name^='iban']").off("keyup");
  $("input[type='number']").off("keyup");
  $("input[type='number']").off("focusout");
}

/**
 * Hide or display an error message when the user
 * inputs invalid characters in text inputs.
 * This is a generic function. These characters should
 * never be used. There is a specific check for things like
 * an iban.
 */
function assignInvalidCharHandlers() {
  let invalidCharsLabels = $(".invalid_chars");
  $.each(invalidCharsLabels, function(key,label){
    $(label).hide();
  });
  $("input[type='text']").on("keyup", function() {
    let input = $(this);
    let label = $("label[for='" + input.prop('id') + "'].invalid_chars");

    // Check the correct input and update the correct label accordingly.
    if (!checkInvalidChars(input.val())) {
      $("button[type='submit']").prop("disabled", true);
      label.show();
      label.text("Invalid characters: <>!#$%^&*+[]{}?:;|'\"\\/~`=");
    } else {
      $("button[type='submit']").prop("disabled", false);
      label.hide();
    }
  });
}

/**
 * Generic function for checking iban fields
 */
function assignIBANHandlers() {
  var timerValidateIBAN;
  $("input[name^='iban']").on("keyup", function() {
    if (timerValidateIBAN) {
      clearTimeout(timerValidateIBAN);
    }
    let input = $(this);
    let label = $("label[for='" + input.prop('id') + "'].label_iban");
    if (input.val().length > 4) {
      label.toggleClass('error',false);
      label.toggleClass('success',false);
      label.text('Validating...');

      timerValidateIBAN = setTimeout(function () {
        validateIBAN(input, label);
      }, 800);
    }
    else {
      label.hide();
    }
  });
}

/**
 * Prevents leading zero's
 */
function assignInvalidNumbersHandlers() {
  $("input[type='number']").on("keyup", function() {
    var numb = $(this).val();
    while (numb.charAt(0) === '0') {         // Assume we remove all leading zeros
      if (numb.length == 1) { break; };       // But not final one.
      if (numb.charAt(1) == '.') { break; };  // Nor one followed by '.'
      numb = numb.substr(1, numb.length-1);
      $(this).val(numb);
    }
  });
  $("input[type='number']").on("focusout", function() {
    var numb = $(this).val();
    if (numb.length == 0) {
      $(this).val(0);
    }
  });
}

/**
 * Checks the input if it does not contain any of the characters
 * defined above in "const invalidChars".
 * @param  string        the string to be checked
 * @return bool          returns true if no chars from invalidChars
 *                       were found.
 */
const checkInvalidChars = (string) => {
    for(let i = 0; i < invalidChars.length;i++){
        if(string.indexOf(invalidChars[i]) > -1){
            // If one of the characters out of invalidChars was found
            // in the string, immediatly return false
            return false;
        }
    }
    return true;
}

/**
 * This method checks the input from an iban input and
 * validates the IBAN following official requirements,
 * using the "iban.js" plugin.
 * @param  jQuery_Object input[name="iban"]   the IBAN input field
 * @param  HTML_label    <label>              the error/success label
 */
function validateIBAN(input, label) {
  // Use the function from the plugin: iban.js
  if (!IBAN.isValid(input.val())) {
    $("button[type='submit']").prop("disabled", true);
    label.toggleClass('error',true);
    label.toggleClass('success',false);
    label.text("Invalid IBAN: please check again!");
    label.show();
  } else {
    $("button[type='submit']").prop("disabled", false);
    label.toggleClass('error',false);
    label.toggleClass('success',true);
    label.text("Valid IBAN!");
    label.show();
  }
}

// with comma for thousands
function format_currency(amount) {
  let i = parseFloat(amount);
  if(isNaN(i)) { i = 0.00; }
  let minus = "";
  if(i < 0) { minus = '-'; }
  i = Math.abs(i);
  i = parseInt((i + .005) * 100);
  i = i / 100;
  let s = Number(i).toLocaleString('en');
  if(s.indexOf('.') < 0) { s += '.00'; }
  if(s.indexOf('.') == (s.length - 2)) { s += '0'; }
  s = minus + s;
  return s;
}
