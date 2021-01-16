function logger (message, color) {
  console.log('%c'+message, 'background: #222; color: '+color)
}

$('a').on('click', function (e) {
  let choiceFrom = this.id.split('B')[0];
  if (choiceFrom == 'signUp') {
    logger('going to signUp', 'orange');
    $('#submitSignUp').attr("disabled", true);
    document.getElementById('submitSignUp').addEventListener('click', (e) => { e.preventDefault(); })
    $('#splashScreen').hide(); $('#formsScreen').show(); $('#signUpForm').show();
  } else if (choiceFrom == 'login') {
    logger('going to login', 'orange');
    $('#submitLogin').attr("disabled", true);
    document.getElementById('submitLogin').addEventListener('click', (e) => { e.preventDefault(); })
    $('#splashScreen').hide(); $('#formsScreen').show(); $('#loginForm').show();

  } else if (choiceFrom == 'back') {
    logger('going to splash screen', 'orange');
    $('#splashScreen').show(); $('#formsScreen').hide(); $('#loginForm').hide(); $('#signUpForm').hide();
  } else {
    logger('mystical error', 'red')
  }
})

let fieldValues = [1,0,0,0,0,0,0,0];
function checkFieldsInput(field, form) {
  let fields = ['stNummer','klas','naam','adres','postcode','woonplaats','leeftijd','email'];

  for (var i = 0; i < fields.length; i++) {
    if (field == fields[i]) {
      fieldValues[i] = 1;
    }
  }

  if (fieldValues.includes(0)) {
    console.log(fieldValues);
    console.log('nog een 0 gevonden')
  } else {
    console.log('nothing found')
    $('#submit'+form).attr("disabled", false);
  }
}

$('#signUpForm>fieldset>input').on('input', function() {
  checkFieldsInput(this.id.split('I')[0], 'SignUp')
})

$('#loginForm>fieldset>input').on('input', function() {
  if (this.id.split('I')[0] == 'password') {
    $('#submitLogin').attr("disabled", false);
  }
})

$('#loginForm>fieldset>input').keyup(function(e) {
  switch (e.keyCode) {
     case 8: // Backspace
     console.log('backspace')
      if ($('#passwordInput')[0].value == "") {
        $('#submitLogin').attr("disabled", true);
      }
        break;
  }
});