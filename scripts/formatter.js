$("form").on("submit", function (event) {
  event.preventDefault();
  const data = $(this).serialize();
  $.post("/xml-toolbox/api/formatter.php", data, function (response) {
    $("#xml-error").html("");
    $("#formatted-xml").html("");
    const res = JSON.parse(response);
    if (res.success) {
      $("#formatted-xml").html(res.data);
      $("#copy-button").show();
    } else {
      $("#copy-button").hide();
      $("#xml-error").html(res.message);
    }
  });
});

$("#copy-button").on("click", function () {
  const copyText = document.getElementById("formatted-xml");
  navigator.clipboard.writeText(copyText.textContent);
  $("#copy-button").html("Copié!");
  setTimeout(function () {
    $("#copy-button").html("Copier");
  }, 3000);
});