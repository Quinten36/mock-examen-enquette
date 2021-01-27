function logger (message, color) {
  console.log('%c'+message, 'background: #222; color: '+color)
}

$('a').on('click', function (e) {
  let choiceFrom = this.id.split('B')[0];
  if (choiceFrom == 'signUp') {
    logger('going to signUp', 'orange');
    $('#submitSignUp').attr("disabled", true);
    // document.getElementById('submitSignUp').addEventListener('click', (e) => { e.preventDefault(); })
    $('#splashScreen').hide(); $('#formsScreen').show(); $('#signUpForm').show();
  } else if (choiceFrom == 'login') {
    logger('going to login', 'orange');
    $('#submitLogin').attr("disabled", true);
    // document.getElementById('submitLogin').addEventListener('click', (e) => { e.preventDefault(); })
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

/*************************************************************************************** CHECK FOR JUST REGISTER *******************/
var myVar;

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function myFunction() {
  myVar = setInterval(alertFunc, 300);
}

function alertFunc() {
  if (getCookie('uuid').length > 2) {
    console.log(getCookie('uuid'));
    $('#splashScreen').hide();
    $('#redirectScreen').show();
  } 
}

myFunction();