 $(function() {
    $( "#slider-range-min" ).slider({
      range: "min",
      value: 1,
      min: 0,
      max: 365,
      slide: function( event, ui ) {
        $( "#amount" ).val( ui.value + " days");
        $(".a, .b, .c, .d").width(ui.value + "%");
      }
    });
    $(".ui-slider-handle").text("<>");
    $( "#amount" ).val( "$" + $( "#slider-range-min" ).slider( "value") + " days");
  });