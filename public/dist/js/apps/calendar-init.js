/*========Calender Js=========*/
/*==========================*/

document.addEventListener("DOMContentLoaded", function () {
  /*=================*/
  //  Calender Date variable
  /*=================*/
  var newDate = new Date();
  function getDynamicMonth() {
    getMonthValue = newDate.getMonth();
    _getUpdatedMonthValue = getMonthValue + 1;
    if (_getUpdatedMonthValue < 10) {
      return `0${_getUpdatedMonthValue}`;
    } else {
      return `${_getUpdatedMonthValue}`;
    }
  }
  /*=================*/
  // Calender Modal Elements
  /*=================*/
  var getModalStartDateEl = document.querySelector("#event-start-date");
  var getModalEndDateEl = document.querySelector("#event-end-date");
  var getModalAddBtnEl = document.querySelector(".btn-add-event");
  var getModalUpdateBtnEl = document.querySelector(".btn-update-event");
  var getModalRecurringBtnEl = document.querySelector(".btn-recurring-event");
  var court_id = $('#court_id').data('court-id');
  var description = document.querySelector('textarea[name="description"]');
  var sport_id = document.querySelector('#select_sport_id');
  var is_private = document.querySelector('#private');
  var is_paid = document.querySelector('#ispaid_reservation');
  var adds_on_total = document.querySelector('#items_total_price');
  var the_grand_total = document.querySelector('#grand_total');
  var minutes = document.querySelector('#demo6');
  var recurring_duration = document.querySelector('#recurring_duration');
  var date = document.querySelector('#event-date');
  var event_start_time = document.querySelector('#event_start')
  var price = document.querySelector('#price_input')
  var event_price = document.querySelector('#court-price');
  var court_reservation_price = document.querySelector('#court_reservation_price')
  var status = document.querySelector('#status');
  var status_id = document.querySelector('#status_id');
  var booking_id = document.querySelector('#booking_id')
  var each_session_min = $('#demo6').val()
  var range_start = ''
  var range_end = ''

  var price_initial;
  var each_session_min;

  var total_items_price = 0;
  var grand_total = 0;
  var court_price = 0;
  selectedItems = [];

  //check session minutes
  var check_session = $('#sport_time_url').data('sport-time');
  sport_id.addEventListener('change', function (e) {
    check_sess()
  });

  function check_sess(update = false) {
    $("#session_minutes_error").empty();
    $('#session_minutes_empty').empty();
    if (court_id && sport_id.value != 0) {
      $.ajax({
        url: check_session,
        data: {
          court_id: court_id,
          sport_id: sport_id.value
        },
        type: "POST",
        success: function (data) {
          $("input[name='demo6']").attr("data-minutes", data.session);
          recurring_duration.value = data.session;
          if (!update) {
            minutes.value = data.session;
          }
          minutes.disabled = false;
          each_session_min = data.session
          price_initial = data.price
          $('#court-price').val(price_initial.toFixed(2))
          $('#court_reservation_price').text(price_initial.toFixed(2));
          if (parseFloat($('#items_total_price').text())) {
            total_items_price = parseFloat($('#items_total_price').text());
          }
          var gd_t = parseFloat(price_initial) + total_items_price;
          $('#grand_total').text(gd_t.toFixed(2))
        }
      });

    }
  }

  function check_sess_up(update = false) {
    $("#session_minutes_error").empty();
    $('#session_minutes_empty').empty();
    if (court_id && sport_id.value != 0) {
      $.ajax({
        url: check_session,
        data: {
          court_id: court_id,
          sport_id: sport_id.value
        },
        type: "POST",
        success: function (data) {
          $("input[name='demo6']").attr("data-minutes", data.session);
          recurring_duration.value = data.session;
          if (!update) {
            minutes.value = data.session;
          }
          minutes.disabled = false;
          each_session_min = data.session
          price_initial = data.price
          // $('#court-price').val(price_initial)
          // $('#court_reservation_price').text(price_initial);
          // if (parseFloat($('#items_total_price').text())) {
          //   total_items_price = parseFloat($('#items_total_price').text());
          // }
          // $('#grand_total').text(parseFloat(price_initial) + total_items_price)
        }
      });

    }
  }

  //price up
  $('.bootstrap-touchspin-up').on('click', function (e) {
    var sport_court_price = parseFloat($('#court-price').val())
    var duration = parseInt($('#demo6').val());
    if (each_session_min < duration) {
      if (duration < 300) {
        sport_court_price += (price_initial * 30) / each_session_min;
      } else if (duration == 300) {
        sport_court_price = (price_initial * 300) / each_session_min;
      }
    }
    $('#court-price').val(sport_court_price.toFixed(2))
    $('#court_reservation_price').text(sport_court_price.toFixed(2))
    if (parseFloat($('#items_total_price').text())) {
      total_items_price = parseFloat($('#items_total_price').text());
    }
    var gd_t = parseFloat(sport_court_price) + total_items_price;
    $('#grand_total').text(gd_t.toFixed(2))
    court_price = sport_court_price;
  })

  //price down
  $('.bootstrap-touchspin-down').on('click', function (e) {
    var sport_court_price = parseFloat($('#court-price').val())
    if (price_initial < sport_court_price) {
      sport_court_price -= (price_initial * 30) / each_session_min;
      $('#court-price').val(sport_court_price.toFixed(2))
      $('#court_reservation_price').text(sport_court_price.toFixed(2))
      if (parseFloat($('#items_total_price').text())) {
        total_items_price = parseFloat($('#items_total_price').text());
      }
      var gd_t = parseFloat(sport_court_price) + total_items_price;
      $('#grand_total').text(gd_t.toFixed(2))
      court_price = sport_court_price;
    }
  })

  $(document).on('change', '.qty_hour', function (e) {
    var total_price = 0;
    if ($('#court-price').val()) {
      court_price = parseFloat($('#court-price').val());
    } else {
      court_price = 0;
    }
    var value = parseInt($(this).val());
    if (value < 1 || isNaN(value)) {
      $(this).val(1);
      return;
    }
    $('.item').each(function () {
      var price = parseFloat($(this).find('.price_item').val());
      var quantity = parseInt($(this).find('.qty_hour').val());
      var item_price = parseFloat(price) * parseInt(quantity);
      total_price += parseFloat(item_price);
    });
    $('#items_total_price').text(total_price)
    grand_total = total_price + court_price;
    $('#grand_total').text(grand_total.toFixed(2))
    total_items_price = total_price;
  });

  $(document).on('input', '.qty_hour', function (e) {
    var total_price = 0;
    if ($('#court-price').val()) {
      court_price = parseFloat($('#court-price').val());
    } else {
      court_price = 0;
    }
    var value = $(this).val();
    if (value < 1 || isNaN(value) || !value) {
      $(this).val(1);
      return;
    }
    $('.item').each(function () {
      var price = parseFloat($(this).find('.price_item').val());
      var quantity = parseInt($(this).find('.qty_hour').val());
      var item_price = parseFloat(price) * parseInt(quantity);
      total_price += parseFloat(item_price);
    });
    $('#items_total_price').text(total_price)
    var grand_total = total_price + court_price;
    $('#grand_total').text(grand_total.toFixed(2))
  });

  $(document).on('input change', '.price_item', function (e) {
    var total_price = 0;
    if ($('#court-price').val()) {
      court_price = parseFloat($('#court-price').val());
    } else {
      court_price = 0;
    }
    var value = parseInt($(this).val());
    if (value < 0 || isNaN(value)) {
      $(this).val(0);
      return;
    }
    $('.item').each(function () {
      var price = parseFloat($(this).find('.price_item').val());
      var quantity = parseInt($(this).find('.qty_hour').val());
      var item_price = parseFloat(price) * parseInt(quantity);
      total_price += parseFloat(item_price);
    });
    $('#items_total_price').text(total_price)
    grand_total = total_price + court_price;
    $('#grand_total').text(grand_total.toFixed(2))
    total_items_price = total_price;
  });

  //editable price
  $('#editable_price').on('click', function (e) {
    $("#court-price").prop("readonly", false);
  });

  //court-price 
  $('#court-price').on('input change', function (e) {
    var value = $(this).val()
    if (!value || isNaN(value) || value < 0) {
      $(this).val(0);
      return;
    }
    $('#court_reservation_price').text(value)
    if (parseFloat($('#items_total_price').text())) {
      total_items_price = parseFloat($('#items_total_price').text());
    }
    var gd_t = parseFloat(value) + total_items_price;
    $('#grand_total').text(gd_t.toFixed(2))
  })

  var calendarsEvents = {
    Danger: "danger",
    Success: "success",
    Primary: "primary",
    Warning: "warning",
  };

  /*=====================*/
  // Calendar Elements and options
  /*=====================*/
  var calendarEl = document.querySelector("#calendar");
  var checkWidowWidth = function () {
    if (window.innerWidth <= 1199) {
      return true;
    } else {
      return false;
    }
  };
  var calendarHeaderToolbar = {
    // left: "prev next addEventButton",
    left: "prev next",
    center: "title",
    right: "dayGridMonth,timeGridWeek,timeGridDay",
  };

  var calendarEventsList = [
    {
      id: 1,
      title: "Event Conf.",
      start: `${newDate.getFullYear()}-${getDynamicMonth()}-01`,
      extendedProps: { calendar: "Danger" },
    },
    {
      id: 2,
      title: "Seminar #4",
      start: `${newDate.getFullYear()}-${getDynamicMonth()}-07`,
      end: `${newDate.getFullYear()}-${getDynamicMonth()}-10`,
      extendedProps: { calendar: "Success" },
    },
    {
      groupId: "999",
      id: 3,
      title: "Meeting #5",
      start: `${newDate.getFullYear()}-${getDynamicMonth()}-09T16:00:00`,
      extendedProps: { calendar: "Primary" },
    },
    {
      groupId: "999",
      id: 4,
      title: "Submission #1",
      start: `${newDate.getFullYear()}-${getDynamicMonth()}-16T16:00:00`,
      extendedProps: { calendar: "Warning" },
    },
    {
      id: 5,
      title: "Seminar #6",
      start: `${newDate.getFullYear()}-${getDynamicMonth()}-11`,
      end: `${newDate.getFullYear()}-${getDynamicMonth()}-13`,
      extendedProps: { calendar: "Danger" },
    },
    {
      id: 6,
      title: "Meeting 3",
      start: `${newDate.getFullYear()}-${getDynamicMonth()}-12T10:30:00`,
      end: `${newDate.getFullYear()}-${getDynamicMonth()}-12T12:30:00`,
      extendedProps: { calendar: "Success" },
    },
    {
      id: 7,
      title: "Meetup #",
      start: `${newDate.getFullYear()}-${getDynamicMonth()}-12T12:00:00`,
      extendedProps: { calendar: "Primary" },
    },
    {
      id: 8,
      title: "Submission",
      start: `${newDate.getFullYear()}-${getDynamicMonth()}-12T14:30:00`,
      extendedProps: { calendar: "Warning" },
    },
    {
      id: 9,
      title: "Attend event",
      start: `${newDate.getFullYear()}-${getDynamicMonth()}-13T07:00:00`,
      extendedProps: { calendar: "Success" },
    },
    {
      id: 10,
      title: "Project submission #2",
      start: `${newDate.getFullYear()}-${getDynamicMonth()}-28`,
      extendedProps: { calendar: "Primary" },
    },
  ];

  /*=====================*/
  // Calendar Select fn.
  /*=====================*/
  // select new event
  var check_time = $('#check_time').data('url');
  var calendarSelect = function (info) {
    $('#select_sport_id').val(0)
    var weekday = moment(info.start).day();
    var date = moment(info.start).format('YYYY-MM-DD');

    // old V
    var start_time = moment(info.startStr).format('HH:mm');
    var end_time = moment(info.endStr).format('HH:mm');

    //new V
    var start_time_new = moment(info.start).format("YYYY-MM-DD HH:mm:ss");
    var end_time_new = moment(info.endStr).format('YYYY-MM-DD HH:mm:ss');

    $('#op_hours').empty();
    $('#day_name').empty();

    $('#player_error').empty();
    $('#user-select').empty();
    $('#new_member_button').css('display', 'none')
    $('#new_member_content').css('display', 'none');
    $('#phone_number_valid').empty()
    $('#full_name').val('')
    $('#birth_date').val('')
    $('#email').val('')
    $('#phone_number').val('')
    $('#search-input').val('')

    //reservation items
    $('#search_input').val('')
    $('#plus_court_items').empty()
    $('#court_reservation_price').text('')
    $('#items_total_price').text('')
    $('#grand_total').text('')
    $('#court-price').val('')
    $('#price_error').empty()

    total_items_price = 0;
    grand_total = 0;
    court_price = 0;
    selectedItems = [];

    if (info.view.type == 'timeGridDay') {
      $.ajax({
        url: check_time,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          court_id: court_id,
          weekday: weekday == 0 ? 7 : weekday,
          time_from: start_time_new,
          time_to: end_time_new,
          date: date
        },
        type: "POST",
        success: function (data) {
          if (!data.available_time) {
            op = data.opening_hours;
            if (op.length == 0) {
              swal({
                title: "NO DATA",
                text: 'NO DATA FOR THIS DAY !!',
                icon: "warning",
              });
              return
            }
            if (!data.same_time_week) {
              op.sort(function (a, b) {
                var timeA = moment(a.opening_time, 'HH:mm:ss');
                var timeB = moment(b.opening_time, 'HH:mm:ss');
                if (timeA.isBefore(timeB)) {
                  return -1;
                } else if (timeA.isAfter(timeB)) {
                  return 1;
                } else {
                  return 0;
                }
              });
              day_number = data.opening_hours[0].weekday == 7 ? 0 : data.opening_hours[0].weekday;
              $('#day_name').append(moment().day(day_number).format('dddd'));

              var html = '<div>';
              for (var i = 0; i < op.length; i++) {
                var item = op[i];
                html += '<div class="col-12 my-3 fs-5 text-primary"><b> Opening Time: ' + moment(item.opening_time, 'HH:mm:ss').format('h:mm A') + ' | ' + 'Closing Time: ' + moment(item.closing_time, 'HH:mm:ss').format('h:mm A') + '</b></div>';
              }
              html += '</div>';
              $('#op_hours').append(html);
              myModalOpening.show();
              return
            } else {
              $('#day_name').append('EveryDay');
              var html = '<div>';
              html += '<div class="col-12 my-3 fs-5 text-primary"><b> Opening Time: ' + moment(op.opening_from, 'HH:mm:ss').format('h:mm A') + ' | ' + 'Closing Time: ' + moment(op.opening_to, 'HH:mm:ss').format('h:mm A') + '</b></div>';
              html += '</div>';
              $('#op_hours').append(html);
              myModalOpening.show();
              return
            }
          }
          //else
          $('#demo6').val('');
          $('#sport_error').empty();
          $("#session_minutes_error").empty();
          $('#session_minutes_empty').empty();
          $('#event_start').val(start_time).prop('disabled', true).prop('readonly', true);
          $('#event-date').val(date)
          minutes.disabled = true;
          sport_id.disabled = false;
          //hon el te8yir
          price.style.display = 'block';
          status.style.display = 'none';
          getModalAddBtnEl.style.display = "block";
          getModalUpdateBtnEl.style.display = "none";
          getModalRecurringBtnEl.style.display = "none";
          myModal.show();
        },
        error: function (err) {
          console.log(err);
        }
      });
    }
  };

  /*=====================*/
  // Calendar AddEvent fn.
  /*=====================*/
  var calendarAddEvent = function () {
    var currentDate = new Date();
    var dd = String(currentDate.getDate()).padStart(2, "0");
    var mm = String(currentDate.getMonth() + 1).padStart(2, "0"); //January is 0!
    var yyyy = currentDate.getFullYear();
    var combineDate = `${yyyy}-${mm}-${dd}T00:00:00`;
    getModalAddBtnEl.style.display = "block";
    getModalUpdateBtnEl.style.display = "none";
    myModal.show();
  };

  //recurring duration
  $("input[name='recurring_duration']").TouchSpin({
    buttondown_class: "btn btn-light-danger text-danger font-medium",
    buttonup_class: "btn btn-light-success text-success font-medium",
    min: 30,
    max: 300,
    step: 30
  });

  //min date 
  $('#recurring_start_date').change(function () {
    var minDate = $('#recurring_start_date').val();
    $('#recurring_end_date').val('')
    $('#recurring_end_date').attr('min', minDate);
  });

  /*=====================*/
  // Calender Event Function
  /*=====================*/
  //click previous event
  var unique_id;
  var calendarEventClick = function (info) {
    $('#sport_error').empty();
    $('#price_error').empty();
    $('#player_error').empty();
    $('#user-select').empty();
    $('#new_member_button').css('display', 'none')
    $('#new_member_content').css('display', 'none');
    $('#phone_number_valid').empty()
    $('#full_name').val('')
    $('#birth_date').val('')
    $('#email').val('')
    $('#phone_number').val('')
    $('#search-input').val('')

    //reservation items
    $('#search_input').val('')
    $('#plus_court_items').empty()
    $('#court-price').text('')
    $('#court_reservation_price').text('')
    $('#items_total_price').text('')
    $('#grand_total').text('')

    var player_id;
    var eventObj = info.event;
    var start_time = moment(info.startStr).format('HH:mm');
    $('#event_start').val(start_time).prop('disabled', false).prop('readonly', false);
    if (eventObj.url) {
      window.open(eventObj.url);
      info.jsEvent.preventDefault();
    } else {
      unique_id = info.event._def.extendedProps.booking_id;
      var getModalEventId = eventObj._def.publicId;
      get_booking_items(getModalEventId)
      document.querySelector("#session_minutes_error").innerHTML = "";
      minutes.disabled = false;
      price.style.display = 'block';
      status.style.display = 'block';
      event_price.value = eventObj._def.extendedProps['price'];
      court_reservation_price.textContent = eventObj._def.extendedProps['price'];
      date.value = eventObj._def.extendedProps['event_date'];
      event_start_time.value = eventObj._def.extendedProps['event_start_time'];
      range_start = eventObj._instance.range.start;
      range_end = eventObj._instance.range.end;
      sport_id.value = eventObj._def.extendedProps['sport_id'];
      check_sess_up(true)
      sport_id.disabled = true;
      minutes.value = eventObj._def.extendedProps['minutes'];
      status_id.value = eventObj._def.extendedProps['status'];
      booking_id.value = eventObj._def.extendedProps['booking_id']
      player_id = eventObj._def.extendedProps['player_id'];
      player_name = eventObj._def.extendedProps['player_name'];
      $('#recurring_start_date').attr('min', eventObj._def.extendedProps['event_date']);

      if (status_id.value == 2) {
        status_id.disabled = true;
      } else {
        status_id.disabled = false;
      }

      if (eventObj._def.extendedProps['is_private'] == 1) {
        is_private.checked = true;
      } else {
        is_private.checked = false;
      }

      if (eventObj._def.extendedProps['is_paid'] == 1) {
        is_paid.checked = true;
      } else {
        is_paid.checked = false;
      }

      description.value = eventObj._def.extendedProps['description'];
      adds_on_total.textContent = eventObj._def.extendedProps['adds_on_total'];
      the_grand_total.textContent = eventObj._def.extendedProps['the_grand_total'];
      total_items_price = eventObj._def.extendedProps['adds_on_total'];
      getModalUpdateBtnEl.setAttribute(
        "data-fc-event-public-id",
        getModalEventId
      );
      getModalRecurringBtnEl.setAttribute(
        "data-fc-recurring-public-id",
        getModalEventId
      );

      const newOption = $('<option>', {
        value: player_id,
        text: player_name
      });

      // Append the new option to the select element
      $('#user-select').append(newOption);

      // Select the new option in the dropdown list
      newOption.prop('selected', true);

      getModalAddBtnEl.style.display = "none";
      if (eventObj._def.extendedProps['event_date'] < moment().format('YYYY-MM-DD')) {
        getModalUpdateBtnEl.style.display = "none";
        getModalRecurringBtnEl.style.display = "none";
      } else {
        getModalUpdateBtnEl.style.display = "block";
        getModalRecurringBtnEl.style.display = "block";
      }
      myModal.show();
    }
  };

  var get_booking_items_url = $('#get_booking_items').data('url')
  //get Items if exist from this reservatio
  function get_booking_items(booking_id) {
    $.ajax({
      url: get_booking_items_url,
      data: {
        booking_id: booking_id
      },
      success: function (data) {
        if (data.length > 0) {
          $('#plus_court_items').removeClass(
            'd-none')
          for (let index = 0; index < data.length; index++) {
            const element = data[index];
            selectedItems.push(element.item_id);
            $('#plus_court_items').append(`
              <div class="row mb-2 px-1 item d-flex align-items-center">
                  <div class="col-3">
                      ${element.name}
                      </div>
                  <div class="col-3">
                      <input class="price_item form-control" value="${element.price}" type="number"/>
                      <input class="id" type="hidden" value="${element.item_id}"/>
                  </div>
                  <div class="col-3">
                      <input value="${element.qty_hour}" type="number" class="qty_hour form-control"/>
                  </div>
                  <div class="col-3">
                      <i class="ti ti-trash fs-3 text-danger cursor-pointer"></i>
                  </div>
              </div>
              `)
          }
        }
      }
    })
  }

  var search_input = $('#search_url').data('url');
  var link = $('#search_url').data('link');

  $('.search-container input').on('input', function () {
    var query = $(this).val().trim();

    const url = window.location.href;
    // Match the ID in the URL using a regular expression
    const match = url.match(/id=(\d+)/);
    var id = match[1]

    if (query.length > 0) {
      $.ajax({
        url: search_input,
        data: {
          name: query,
          id: id
        },
        type: "POST",
        success: function (data) {
          var results = $('.search-results');
          results.empty();
          if (data.data.length > 0) {
            for (var i = 0; i < data.data.length; i++) {
              var item = data.data[i];
              var li = $('<li style="list-style: none;" class="my-2">');
              var text_image = item.img == null ?
                'images/courts/no-image.png' : item
                  .img;
              var img = $('<img width="50" height="50">').attr('src', link + "/" + text_image);
              var title = $('<span class="item_name mx-3">').text(item
                .name);
              var price = $('<span class="mx-3 item_price">').text(item.price)
              var item_id = item.item_id;

              // Use a closure to capture the correct value of item_id
              (function (item_id) {
                li.on('click', function () {
                  if (selectedItems.includes(item_id)) {
                    li.addClass('disabled');
                    $('#search_input').val('')
                    results.hide()
                    return
                  } else {
                    $('#search_input').val('')
                    var title = $(this).find('.item_name')
                      .text();
                    var price_i = $(this).find('.item_price')
                      .text();
                    $('#plus_court_items').removeClass(
                      'd-none')
                    $('#plus_court_items').append(`
                            <div class="row mb-2 px-1 item d-flex align-items-center">
                                <div class="col-3">
                                    ${title}
                                    </div>
                                <div class="col-3">
                                    <input class="price_item form-control" value="${price_i}" type="number">
                                    <input class="id" type="hidden" value="${item_id}"/>
                                </div>
                                <div class="col-3">
                                    <input value="1" type="number" class="qty_hour form-control"/>
                                </div>
                                <div class="col-3">
                                    <i class="ti ti-trash fs-3 text-danger cursor-pointer"></i>
                                </div>
                            </div>
                        `)
                    // Add the item to the selectedItems array and disable the li element
                    selectedItems.push(item_id);
                    $(this).addClass('disabled');
                    results.hide();
                    total_items_price += parseFloat(price_i);
                    $('#items_total_price').text(total_items_price)
                    if ($('#court_reservation_price').text()) {
                      court_price = $('#court_reservation_price')
                        .text();
                    } else {
                      court_price = 0;
                    }
                    grand_total = parseFloat(total_items_price) +
                      parseFloat(court_price);
                    $('#grand_total').text(grand_total.toFixed(2))
                  }
                });
              })(item_id);
              li.append(img);
              li.append(title);
              li.append(price);
              results.append(li);
            }
            results.show();
          } else {
            results.hide();
          }
        }
      })
    } else {
      $('.search-results').hide();
    }
  });

  const myDiv = document.getElementById("search-results");

  // Add click event listener to the document object
  document.addEventListener("click", function (event) {
    // Check if the clicked element is not the div or any of its child elements
    if (!myDiv.contains(event.target)) {
      // Hide the div
      myDiv.style.display = "none";
      $('#search_input').val('')
    }
  });

  // Add a click event listener to the trash icon
  $('#plus_court_items').on('click', '.ti-trash', function () {
    // Get the parent element of the trash icon
    var item = $(this).closest('.item');
    // Get the ID of the item from the hidden input field
    var item_id = item.find('.id').val();
    var item_price = item.find('.price_item').val()
    var item_qty = item.find('.qty_hour').val()
    var each_item_total = item_price * item_qty;
    if ($('#court-price').val()) {
      court_price = parseFloat($('#court-price').val())
    } else {
      court_price = 0;
    }
    // Remove the item from the selectedItems array
    var index = selectedItems.indexOf(parseInt(item_id));
    if (index > -1) {
      selectedItems.splice(index, 1);
      // Remove the item from the DOM
      item.remove();
      total_items_price -= parseFloat(each_item_total);
      $('#items_total_price').text(total_items_price)
      grand_total = parseFloat(total_items_price) +
        parseFloat(court_price);
      $('#grand_total').text(grand_total)
    }
  });


  /*=====================*/
  // Active Calender
  /*=====================*/
  var url = $('#calendar').data('route')
  var calendar = new FullCalendar.Calendar(calendarEl, {
    // ... other FullCalendar options
    selectAllow: function (selectInfo) {
      // Get today's date
      var today = new Date();
      today.setHours(0, 0, 0, 0); // Set the time to midnight

      // Get the selected start date of the event
      var startDate = selectInfo.start;

      // Check if the start date of the event is before today
      if (startDate < today) {
        // Disable selecting the event
        return false;
      }
      // Allow selecting the event
      return true;
    },
    selectable: true,
    height: checkWidowWidth() ? 900 : 1052,
    // initialView: checkWidowWidth() ? "listWeek" : "dayGridMonth",
    initialView: 'timeGridDay',
    initialDate: moment().format('YYYY-MM-DD'),
    headerToolbar: calendarHeaderToolbar,
    // nextDayThreshold: "00:00:00",
    events: function (fetchInfo, successCallback, failureCallback) {
      // Make an AJAX call to fetch the events
      $.ajax({
        url: url,
        data: {
          // view: fetchInfo.view.type,
          date: moment(fetchInfo.startStr).format('YYYY-MM-DD'),
          start: moment(fetchInfo.startStr).format('YYYY-MM-DD'),
          end: moment(fetchInfo.endStr).format('YYYY-MM-DD'),
          court_id: court_id
        },
        success: function (data) {
          var events = [];
          // var events = [{
          //   title: 'Event',
          //   start: '2023-09-08T23:00:00',
          //   end: '2023-09-09T01:00:00'
          // }];
          for (var i = 0; i < data.length; i++) {
            events.push({
              id: data[i]['id'],
              title: data[i]['court_name'] + '/' + data[i]['sport'],
              // start: moment(data[i]['date'] + ' ' + data[i]['time_from'], 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DDTHH:mm:ss'),
              // end: moment(data[i]['date'] + ' ' + data[i]['time_to'], 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DDTHH:mm:ss'),
              start: moment(data[i]['date_start'], "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DDTHH:mm:ss"),
              end: moment(data[i]['date_end'], "YYYY-MM-DD HH:mm:ss").format("YYYY-MM-DDTHH:mm:ss"),
              extendedProps: data[i]['status'] == 0 ? { calendar: "Warning" } : data[i]['status'] == 1 ? { calendar: "Success" } : { calendar: "Danger" },
              event_date: data[i]['date'],
              status: data[i]['status'],
              court_id: data[i]['court_id'],
              sport_id: data[i]['sport_id'],
              event_start_time: data[i]['time_from'],
              minutes: data[i]['duration'],
              is_private: data[i]['is_private'],
              is_paid: data[i]['is_paid'],
              adds_on_total: data[i]['add_on_price'],
              the_grand_total: data[i]['grand_total'],
              description: data[i]['notes'],
              price: data[i]['total_price'],
              status: data[i]['status'],
              booking_id: data[i]['id'],
              player_id: data[i]['user_id'],
              player_name: data[i]['player_name']
            })
          }
          // Call the success callback with the events array
          successCallback(events);
        },
        error: function (xhr, status, error) {
          // Call the failure callback with the error message
          failureCallback(error);
        }
      });
    },
    select: calendarSelect,
    unselect: function () {
      console.log("unselected");
    },
    eventClassNames: function ({ event: calendarEvent }) {
      const getColorValue =
        calendarsEvents[calendarEvent._def.extendedProps.calendar];
      return [
        `bg-${getColorValue} text-light cursor-pointer border border-${getColorValue}`,
      ];
    },
    eventClick: calendarEventClick,
    windowResize: function (arg) {
      if (checkWidowWidth()) {
        calendar.changeView("listWeek");
        calendar.setOption("height", 900);
      } else {
        calendar.changeView("dayGridMonth");
        calendar.setOption("height", 1052);
      }
    },
  });

  /*=====================*/
  // Update Calender Event
  /*=====================*/
  //update previous event !!!!!!
  var update_booking = $('#update_booking').data('update-booking');
  getModalUpdateBtnEl.addEventListener("click", function () {
    var getPublicID = this.dataset.fcEventPublicId;
    var getEvent = calendar.getEventById(getPublicID);
    var starttime = $('#event_start').val();
    var minutes = parseInt($('#demo6').val(), 10);
    var time_from = moment(starttime, 'h:mm A').format(
      'HH:mm:ss'); // Convert the timestamp to 24-hour format
    var time_to = moment(starttime, 'h:mm A').add(minutes, 'minutes').format('HH:mm:ss');
    var notes = $('textarea[name="description"]').val();
    var is_private = $('#private').is(':checked') ? 1 : 0;
    var is_paid = $('#ispaid_reservation').is(':checked') ? 1 : 0;
    var price = $('#court-price').val();
    var date = $('#event-date').val();
    var weekday = moment(date, 'YYYY-MM-DD').day();
    var player_id = $('#user-select').val()
    var total_price = $('#court-price').val()

    var dateTime_from = moment(date + ' ' + time_from).format('YYYY-MM-DD HH:mm:ss');
    var dateTime_to = moment(dateTime_from).add(minutes, 'minutes').format('YYYY-MM-DD HH:mm:ss');

    if (player_id == 0 || player_id == '' || player_id == null) {
      $('#player_error').append(`<span class="text-danger text-uppercase err">player required !!</span>`)
    } else {
      $('#player_error').empty()
    }

    if (isNaN(minutes)) {
      $('#session_minutes_empty').append(`<span class="text-danger text-uppercase err">fill the session duration !!</span>`)
    } else {
      $('#session_minutes_empty').empty();
    }

    if (minutes < each_session_min) {
      $('#session_minutes_error').append(`<span class="text-danger text-uppercase err">The Session Duration should not be less than <b>${each_session_min}</b></span>`)
    } else {
      $('#session_minutes_error').empty()
    }


    if (price > 0) {
      $('#price_error').empty()
    } else {
      $('#price_error').append(`<span class="text-danger text-uppercase err">Price is required !!</span>`)
    }

    if ($('.err').length == 0) {
      $.ajax({
        url: update_booking,
        data: {
          date: date,
          id: booking_id.value,
          court_id: court_id,
          // time_from: time_from,
          // time_to: time_to,
          time_from:dateTime_from,
          time_to:dateTime_to,
          is_private: is_private ? 1 : 0,
          is_paid: is_paid ? 1 : 0,
          notes: notes,
          duration: minutes,
          price: price,
          weekday: weekday == 0 ? 7 : weekday,
          status: status_id.value,
          player_id: player_id,
          total_price: total_price,
          add_on: total_items_price,
        },
        type: "POST",
        success: function (data) {
          if (data.available_time) {
            adds_on(booking_id.value, true)
          } else {
            swal({
              title: "Error",
              text: 'THIS TIME IS ALREADY TAKEN BY ANOTHER RESERVATION, OR NOT INCLUDED IN COURT OPENING HOURS !!',
              icon: "error",
            });
            return
          }
          // if (data.data.status == 2) {
          //   location.reload()
          // }
          // if (data.success) {
          //   console.log(data.data);
          //   getEvent.setExtendedProp("calendar", data.data.status == 0 ? "Warning" : data.data.status == 1 ? "Success" : "Danger");
          //   getEvent.setExtendedProp("description", data.data.notes);
          //   getEvent.setExtendedProp("event_start_time", data.data.time_from);
          //   getEvent.setExtendedProp("is_private", data.data.is_private);
          //   getEvent.setExtendedProp("is_paid", data.data.is_paid);
          //   // getEvent.setExtendedProp("is_paid", data.data.grand_total);
          //   // getEvent.setExtendedProp("is_paid", data.data.add_on_price);
          //   getEvent.setExtendedProp("minutes", data.data.duration);
          //   getEvent.setExtendedProp("price", data.data.price);
          //   getEvent.setExtendedProp("sport_id", data.data.sport_id);
          //   getEvent.setExtendedProp("player_id", data.data.user_id);
          //   getEvent.setExtendedProp("player_name", data.data.full_name);
          //   getEvent.setExtendedProp("status", data.data.status);
          //   myModal.hide();
          // }
        },
        error: function (err) {
          console.log(err);
        }
      });
    }
  });

  /*===================*/
  //select Reccuring
  var storerecurring = $('#storerecurring').data('url')
  getModalRecurringBtnEl.addEventListener("click", function () {

    var getPublicID = $(this).data('fc-recurring-public-id');
    var getEvent = calendar.getEventById(getPublicID);

    $('#recurring_day').val(0);
    $('#recurring_start_time').val('')
    check_sess();
    $('#recurring_start_date').val('')
    $('#recurring_end_date').val('')

    //empty errors
    $('#recurring_start_error').empty()
    $('#recurring_start_date_error').empty()
    $('#recurring_end_date_error').empty()
    $('#recurring_day_error').empty()
    $('#recurring_duration_empty').empty()
    $('#recurring_duration_error').empty()
    $('#player_reccuring_error').empty()

    //recurring success modal remove previous errors
    $('#available_days').empty();
    $('#not_booked_days').empty();

    myModal.hide()
    recurringModal.show()
  });

  //add recurring 
  $(document).on('click', '#storerecurring', function () {
    //empty errors
    $('#recurring_start_error').empty()
    $('#recurring_start_date_error').empty()
    $('#recurring_end_date_error').empty()
    $('#recurring_day_error').empty()
    $('#recurring_duration_empty').empty()
    $('#recurring_duration_error').empty()

    // Your code to handle the click event goes here
    var weekday = $('#recurring_day').val()
    var starttime = $('#recurring_start_time').val();
    var minutes = parseInt($('#recurring_duration').val(), 10);
    var time_from = moment(starttime, 'h:mm A').format(
      'HH:mm:ss'); // Convert the timestamp to 24-hour format
    var time_to = moment(starttime, 'h:mm A').add(minutes, 'minutes').format('HH:mm:ss');
    var start_date = $('#recurring_start_date').val();
    var end_date = $('#recurring_end_date').val();
    var id_sport = sport_id.value;
    var player_id = $('#user-select').val()

    if (!player_id || player_id < 1) {
      $('#player_reccuring_error').append(`<span class="text-danger text-uppercase err">player is required !!</span>`)
    } else {
      $('#player_reccuring_error').empty()
    }

    if (!starttime) {
      $('#recurring_start_error').append(`<span class="text-danger text-uppercase err">time from is required !!</span>`)
    } else {
      $('#recurring_start_error').empty()
    }
    if (!start_date) {
      $('#recurring_start_date_error').append(`<span class="text-danger text-uppercase err">start date is required !!</span>`)
    } else {
      $('#recurring_start_date_error').empty()
    }
    if (!end_date) {
      $('#recurring_end_date_error').append(`<span class="text-danger text-uppercase err">end date is required !!</span>`)
    } else {
      $('#recurring_end_date_error').empty()
    }
    if (isNaN(weekday) || weekday == 0 || weekday == null) {
      $('#recurring_day_error').append(`<span class="text-danger text-uppercase err">seleting a day is required !!</span>`)
    } else {
      $('#recurring_day_error').empty()
    }
    if (isNaN(minutes)) {
      $('#recurring_duration_empty').append(`<span class="text-danger text-uppercase err">fill the session duration !!</span>`)
    } else {
      $('#recurring_duration_empty').empty();
    }
    if (minutes < each_session_min) {
      $('#recurring_duration_error').append(`<span class="text-danger text-uppercase err">The Session Duration should not be less than <b>${each_session_min}</b></span>`)
    } else {
      $('#recurring_duration_error').empty()
    }
    if ($('.err').length == 0) {
      $.ajax({
        url: storerecurring,
        data: {
          booking_id: booking_id.value,
          court_id: court_id,
          time_from: time_from,
          time_to: time_to,
          start_date: start_date,
          end_date: end_date,
          duration: minutes,
          weekday: weekday == 7 ? 0 : weekday,
          sport_id: id_sport,
          player_id: player_id
        },
        type: "POST",
        success: function (data) {
          if (data.success) {

            recurringModal.hide()
            bookedDates.show()

            if (data.booked_dates.length > 0) {
              var booked_days = data.booked_dates;
              var html = '<div> <span class="fs-6 mb-2 text-info text-uppercase">successfully booked sessions in: </span>'
              for (let i = 0; i < booked_days.length; i++) {
                html += '<div class="text-success my-1 h5">' + booked_days[i] + '</div>';
              }
              html += '</div>';
              $('#available_days').append(html)
            } else {
              $('#available_days').append(`<div class="text-info text-uppercase h4">unfortunately there is no available reservation !! </b></div>`)
            }

            if (data.not_available_dates.length > 0) {
              var not_booked_days = data.not_available_dates;
              var html = '<div> <span class="fs-6 mb-2 text-info text-uppercase">Not Available Dates: </span>'
              for (let i = 0; i < not_booked_days.length; i++) {
                html += '<div class="text-danger my-1 h5">' + not_booked_days[i] + '</div>';
              }
              html += '</div>';
              $('#not_booked_days').append(html)
            } else {
              $('#not_booked_days').append(``)
            }
          }
        },
        error: function (err) {
          console.log(err);
        }
      });
    }

  })
  // Relaod page on reccuring
  document.getElementById('booked_days').addEventListener('hidden.bs.modal', function (event) {
    console.log('Modal closed');
    location.reload()
  });

  /*=====================*/
  // Add Calender Event
  /*=====================*/
  //add new event
  getModalAddBtnEl.addEventListener("click", function (fetchInfo) {

    $("#session_minutes_error").empty();
    $('#session_minutes_empty').empty();
    $('#sport_error').empty();
    $('#player_error').empty();
    $('#search-input').val('');

    var player_id = $('#user-select').val();
    var starttime = $('#event_start').val();
    var minutes = parseInt($('#demo6').val(), 10);
    var time_from = moment(starttime, 'h:mm A').format(
      'HH:mm'); // Convert the timestamp to 24-hour format
    var time_to = moment(starttime, 'h:mm A').add(minutes, 'minutes').format('HH:mm');
    var sport_id = $('#select_sport_id').val();
    var notes = $('textarea[name="description"]').val();
    var is_private = $('#private').is(':checked') ? 1 : 0;
    var is_paid = $('#ispaid_reservation').is(':checked') ? 1 : 0;
    var date = $('#event-date').val();
    var book_url = $('#book_event').data('url');
    var weekday = moment(date, 'YYYY-MM-DD').day();
    var total_price = $('#court-price').val()
    var price = parseFloat(total_price);

    var dateTime_from = moment(date + ' ' + time_from).format('YYYY-MM-DD HH:mm:ss');
    var dateTime_to = moment(dateTime_from).add(minutes, 'minutes').format('YYYY-MM-DD HH:mm:ss');

    if (!player_id || player_id == 0 || player_id == null) {
      $('#player_error').append(`<span class="text-danger text-uppercase err">player is required !!</span>`)
    } else {
      $('#player_error').empty();
    }
    if (!isNaN(price) || price < 0) {
      $('#price_error').empty()
    } else {
      $('#price_error').append(`<span class="text-danger text-uppercase err">Price is required !!</span>`)
    }

    if (isNaN(minutes)) {
      $('#session_minutes_empty').append(`<span class="text-danger text-uppercase err">fill the session duration !!</span>`)
    } else {
      $('#session_minutes_empty').empty();
    }

    if (minutes < each_session_min) {
      $('#session_minutes_error').append(`<span class="text-danger text-uppercase err">The Session Duration should not be less than <b>${each_session_min}</b></span>`)
    } else {
      $('#session_minutes_error').empty()
    }

    if (sport_id == 0 || !sport_id) {
      $('#sport_error').append(`<span class="text-danger text-uppercase err">Sport Type is required !!</span>`)
    } else {
      $('#sport_error').empty();
    }

    if ($('.err').length == 0) {
      $.ajax({
        url: book_url,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          player_id: player_id,
          court_id: court_id,
          weekday: weekday == 0 ? 7 : weekday,
          date: date,
          // time_from: time_from,
          // time_to: time_to,
          time_from:dateTime_from,
          time_to:dateTime_to,
          sport_id: sport_id,
          is_private: is_private ? 1 : 0,
          is_paid: is_paid ? 1 : 0,
          notes: notes,
          duration: minutes,
          total_price: total_price,
          add_on: total_items_price,
        },
        type: "POST",
        success: function (data) {

          if (!data.available_time) {
            swal({
              title: "Error",
              text: 'THIS TIME IS ALREADY TAKEN BY ANOTHER RESERVATION, OR NOT INCLUDED IN COURT OPENING HOURS !!',
              icon: "error",
            });
            return
          }
          if (data.error) {
            let errorString = "";
            for (const [key, value] of Object.entries(data.errors)) {
              errorString += `${value}\n`;
            }
            swal({
              title: "Error",
              text: errorString,
              icon: "error",
            });
            return;
          }

          if (data.data[0]['id']) {
            var booking_id = data.data[0]['id'];
            if ($('.item').length > 0) {
              adds_on(booking_id, false)
            } else {
              swal({
                title: 'RESERVATION ADDED SUCCESSFULLY',
                icon: 'success'
              }).then(() => {
                location.reload()
              })
            }
            calendar.addEvent({
              id: data.data[0]['id'],
              title: data.data[0]['court_name'] + '/' + data.data[0]['sport'],
              // start: moment(data.data[0]['date'] + ' ' + data.data[0]['time_from'], 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DDTHH:mm:ss'),
              // end: moment(data.data[0]['date'] + ' ' + data.data[0]['time_to'], 'YYYY-MM-DD HH:mm:ss').format('YYYY-MM-DDTHH:mm:ss'),
              start:data.data[0]['date_start'],
              end:data.data[0]['date_end'],
              allDay: false,
              extendedProps: data.data[0]['status'] == 0 ? { calendar: "Warning" } : data.data[0]['status'] == 1 ? { calendar: "Success" } : { calendar: "Danger" },
              event_date: data.data[0]['date'],
              status: data.data[0]['status'],
              court_id: data.data[0]['court_id'],
              sport_id: data.data[0]['sport_id'],
              event_start_time: data.data[0]['time_from'],
              minutes: data.data[0]['duration'],
              is_private: data.data[0]['is_private'],
              is_paid: data.data[0]['is_paid'],
              the_grand_total: data.data[0]['grand_total'],
              adds_on_total: data.data[0]['add_on_price'],
              price: data.data[0]['price'],
              description: data.data[0]['notes'],
              booking_id: data.data[0]['id'],
              palyer_id: data.data[0]['user_id'],
              player_name: data.data[0]['full_name']
            });
          }
        },
        error: function (err) {
          console.log(err);
        }
      });
    }

  })

  var reservation_items_url = $('#book_event').data('reservation-items-url');
  function adds_on(booking_id, update = false) {
    // create an empty array to hold the items
    var items = [];
    // loop through each div element with the "item" class
    $(".item").each(function () {
      // get the name and price from the span elements in the div element
      var item_id = $(this).find(".id").val();
      var price = $(this).find(".price_item").val();
      var qty_hour = $(this).find('.qty_hour').val();

      // create an object with the name and price properties
      var item = {
        item_id: item_id,
        price: price,
        qty_hour: qty_hour,
        update: update
      };
      // add the object to the items array
      items.push(item);
    });
    // send the array of objects to the back end using AJAX
    $.ajax({
      url: reservation_items_url,
      type: "POST",
      data: {
        items: items,
        booking_id: booking_id,
        update: update
      },
      success: function (response) {
        if (response.success) {
          swal({
            title: 'RESERVATION ADDED SUCCESSFULLY',
            icon: 'success'
          }).then(() => {
            location.reload()
          })
        } else {
          swal({
            title: 'RESERVATION UPDATED SUCCESSFULLY',
            icon: 'success'
          }).then(() => {
            location.reload()
          })
          // myModal.hide()
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
      }
    });
  }
  /*=====================*/
  // Calendar Init
  /*=====================*/
  calendar.render();
  var myModal = new bootstrap.Modal(document.getElementById("eventModal"));
  var recurringModal = new bootstrap.Modal(document.getElementById("recurringModal"));
  var myModalOpening = new bootstrap.Modal(document.getElementById("opening_hours"));
  var bookedDates = new bootstrap.Modal(document.getElementById("booked_days"));
  document.getElementById("eventModal").addEventListener("hidden.bs.modal", function (event) {
    description.value = "";
    is_private.checked = false;
    is_paid.checked = false;
    var getModalIfCheckedRadioBtnEl = document.querySelector(
      'input[name="event-level"]:checked'
    );
    if (getModalIfCheckedRadioBtnEl !== null) {
      getModalIfCheckedRadioBtnEl.checked = false;
    }
  });

});

