  var PAGECONTACT ={};
  PAGECONTACT.sendContact = function(){
    $('.subscribe-fr').submit(function(event) {
      event.preventDefault();
      var _this=  $(this);
      _this.find('button[type="submit"]').attr('disabled','disabled');
      var textButton = $(_this).find('button[type=submit]').text();
      $('.bgloading').fadeIn(200);
      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize()+'&'+$(this).find('button[type="submit"]').attr('name')+'=""',
        beforeSend: function(){
          $(_this).find('button[type=submit]').text('Processing...');
          $(_this).find('button[type=submit]').addClass('active');
        }
      })
      .done(function(data) {
        try{
          var json = JSON.parse(data);
          if((json.code) == 200){
            toastr['success'](json.message);
            window.location.reload();
          }
          else{
            setTimeout(function()
            {
              _this.find('button[type="submit"]').prop('disabled',false);
              $(_this).find('button[type=submit]').text(textButton);
              $(_this).find('button[type=submit]').removeClass('active');
            },2000);
            toastr['error'](json.message);
          }
        }
        catch(ex){
        }
      })
      .fail(function() {
      })
      .always(function() {
      });
    });
  }

  $(function() {
    PAGECONTACT.sendContact();
  });