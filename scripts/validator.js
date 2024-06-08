$("form").on("submit", function (event) {
  event.preventDefault();
  const data = $(this).serialize();
  $.post("/xml-toolbox/api/validator.php", data, function (response) {
    console.log(response);
    const res = JSON.parse(response);
    $("#alert-container").removeClass("hidden");
    if (res.success) {    
      $("#alert-container").removeClass("bg-red-50 border-red-300 text-red-800");
      $("#alert-container").addClass("bg-blue-50 border-blue-300 text-blue-800");
      $("#alert-text").html(res.message);
    } else {
      $("#alert-container").removeClass("bg-blue-50 border-blue-300 text-blue-800");
       $("#alert-container").addClass("bg-red-50 border-red-300 text-red-800");
       $("#alert-text").html(res.message);
    }
  });
});
