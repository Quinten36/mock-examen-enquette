function showFetchedEnquette(data) {
  $('#travelDistance').val(data.travelDistance);
  $('#travelTime').val(data.travelTime);

  $("#travelMethods>option").each(function(){
    if ($(this).val() == data.travelMethods)
      $(this).attr("selected","selected");
  });

  $("#startTimeLessons>option").each(function(){
    if ($(this).val() == data.startTime)
      $(this).attr("selected","selected");
  });

  $("#endTimeLessons>option").each(function(){
    if ($(this).val() == data.endTime)
      $(this).attr("selected","selected");
  });

  if (data.travelComments.length > 4) {
    $('#travelComments').val(data.travelComments);
  }
}

var getEnquette = function() {
  try {
    $.post('ajax.php', {
      _action: 'get',
      _what: 'getEnquette'
    }, function(returndata) {
      if (returndata.substr(0, 14) == '{"status":"ok"') {
        var fetchdata = jQuery.parseJSON(returndata);
        // console.log(fetchdata);
        showFetchedEnquette(fetchdata.response);
      } else {
        console.log('unknownOutput: '+returndata)
      }
    });
  } catch (error) {
    console.log(error);
  }
};

$('#profileBtn').on('click', function() {
  let target = $('#editProfile')[0]
  target.classList.toggle('hide')
  // $('#editProfile').show();
})

$('#startEnquette').on('click', function() {
  let target = $('#enquetteForm')[0]
  target.classList.toggle('hide')
  // $('#editProfile').show();
})

$('#editEnquette').on('click', function() {
  let target = $('#editEnquetteForm')[0]
  target.classList.toggle('hide')
  console.log('begin')

  getEnquette();

})

$('#returnEditProfile').on('click', function () {
  let target = $('#editProfile')[0]
  target.classList.add('hide')
  // $('#editProfile').hide();
})

function hideStartEnquette() {
  console.log('hide start')
  $('#student')[0].classList.remove('hide');
  $('#startEnquette')[0].classList.add('hide');
}

function hideEditEnquette() {
  console.log('hide edit')
  $('#student')[0].classList.remove('hide');
  $('#editEnquette')[0].classList.add('hide');
}

function showTeacher() {
  $('#teacher')[0].classList.remove('hide');
  $('#student').hide();
  $('#teacher').show();
}

function showStudent() {
  $('#student')[0].classList.remove('hide');
  $('#teacher').hide();
  $('#student').show();
}

function popupProfile(data) {
  console.log(data);
  //sert data in modal
}

function getProfile(uuid) {
  try {
    $.post('ajax.php', {
      _action: 'get',
      _what: 'getStudentProfile',
      _uuid: uuid
    }, function(returndata) {
      if (returndata.substr(0, 14) == '{"status":"ok"') {
        var fetchdata = jQuery.parseJSON(returndata);
        // console.log(fetchdata);
        popupProfile(fetchdata.response);
      } else {
        console.log('unknownOutput: '+returndata)
      }
    });
  } catch (error) {
    console.log(error);
  }
}

function displayEnquette(data) {
  console.log(data);
  let body = $('tbody')[0];
  let row = document.createElement('tr');

  let uuid = document.createElement('td');
  uuid.innerHTML = data.uuid;
  uuid.classList.add('hide');
  
  var name = document.createElement('td');
  let link = '<button onclick="getProfile(\''+data.uuid+'\');" class="studentProfile">'+data.name+'</button>';
  name.innerHTML = link;

  let travelDistance = document.createElement('td');
  travelDistance.innerHTML = data.travelDistance;

  let travelTime = document.createElement('td');
  travelTime.innerHTML = data.travelTime;

  let travelMethods = document.createElement('td');
  travelMethods.innerHTML = data.travelMethods;

  let startTime = document.createElement('td');
  startTime.innerHTML = data.startTime;

  let endTime = document.createElement('td');
  endTime.innerHTML = data.endTime;

  let travelComments = document.createElement('td');
  travelComments.innerHTML = data.travelComments;

  let lastEdited = document.createElement('td');
  lastEdited.innerHTML = data.lastEdited;

  row.append(uuid, name, travelDistance, travelTime, travelMethods, startTime, endTime, travelComments, lastEdited);
  body.append(row);
}

// document.getElementsByClassName('studentProfile').addEventListener('click', function() {
//   console.log('bey')
//   popupProfile(uuid)
// }, false)

// $('.studentProfile').on('click', function() {
//   console.log('haai')
// });