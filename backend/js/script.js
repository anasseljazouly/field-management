//calendar
$(document).ready(function () {
  // $("div#for-student").hide();
  // $("div#for-teacher").hide();
  $("#form1").on("change", function () {
    $("#form2").trigger("reset");
    var form1 = $("#form1").serialize();
    $("option[class='option-seance']").remove();
    $("option[class='option-class']").remove();
    console.log(form1);
    $.post(
      "controllers/calendar.php",
      {
        changeseance: "yes",
        form1: form1,
      },
      function (data) {
        data = JSON.parse(data);
        //console.log(data);
        for (var x of data) {
          var optText = x["NAME_elem_M"];
          var optValue = x["id_prof"];
          for (var i = 1; i <= 4; i++) {
            $("select[name=seance" + i + "]").append(
              $("<option>")
                .val(optValue)
                .text(optText)
                .addClass("option-seance")
            );
          }
        }
      }
    );
    $.post(
      "controllers/calendar.php",
      {
        changeclass: "yes",
      },
      function (data) {
        data = JSON.parse(data);

        for (i = 1; i <= 4; i++) {
          for (var x of data) {
            var opttext = x["Type_class"];
            var optvalue = x["ID_class"];

            $("select[name=class" + i + "]").append(
              $("<option>").val(optvalue).text(opttext).addClass("option-class")
            );
          }
        }
      }
    );
    $("#form1").trigger("submit");
    $("#form1").trigger("submit");
  });
  //////////////////////
  $("#form1").on("submit", function (e) {
    e.preventDefault();
    var semester = $("select[name=semester]").val();
    var year = $("select[name=year]").val();
    var periode = $("select[name=periode]").val();
    var date = $("input[name=date-emploi]").val();
    var form1 = $("#form1").serialize();

    if (semester != "" && year != "" && periode != "" && date != "") {
      $.post(
        "controllers/calendar.php",
        {
          semester: semester,
          year: year,
          periode: periode,
          date: date,
          form1: form1,
        },
        function (data) {
          console.log(data);
          data = JSON.parse(data);
          console.log(data);
          for (var i = 0; i < data.length; i++) {
            if (data[i]["year_s"] != year) {
              $(
                `select[name="seance${data[i]["seance_n"]}"] option[value="${data[i]["id_prof"]}"]`
              )
                .attr("disabled", true)
                .css("color", "red");
              $(
                `select[name="class${data[i]["seance_n"]}"] option[value="${data[i]["CLASS_S"]}"]`
              )
                .attr("disabled", true)
                .css("color", "red");
            } else {
              $(`select[name="seance${data[i]["seance_n"]}"]`).val(
                data[i]["id_prof"]
              );
              $(`select[name="class${data[i]["seance_n"]}"]`).val(
                data[i]["CLASS_S"]
              );
            }
          }
        }
      );
    } else {
      alert("missing data");
    }
  });
  $("#confirm-btn").on("click", function (e) {
    e.preventDefault();
    var semester = $("select[name=semester]").val();
    var year = $("select[name=year]").val();
    var periode = $("select[name=periode]").val();
    var date = $("input[name=date-emploi]").val();
    var field = $("h2[id=field]").text();
    var form = $("#form1").serialize();
    form = form.concat($("#form2").serialize());
    //console.log(form);
    if (semester != "" && year != "" && periode != "" && date != "") {
      $.post(
        "controllers/calendar.php",
        {
          form: form,
          confirm_btn: "confirm_btn",
          field: field,
        },
        function (data) {
          console.log(data);
        }
      );
    } else {
      alert("missing data");
    }
  });
  //---------------------------------------------------------------------
  //module_element

  $("#profname").one("click", function (e) {
    $.post(
      "controllers/module_element.php",
      {
        "load-prof": "load-prof",
      },
      function (data) {
        data = JSON.parse(data);
        // console.log(data);

        for (let x of data) {
          var optText = x["FIRST_NAME_u"] + " " + x["SECOND_NAME_u"];
          var optValue = x["ID_T"];
          $("select[name=profname]").append(
            $("<option>").val(optValue).text(optText)
          );
        }
      }
    );
  });
  //element de module
  $("#confirm-btn-elem").on("click", function (e) {
    e.preventDefault();
    var semester = $("select[name=semester]").val();
    var year = $("select[name=year]").val();
    var periode = $("select[name=periode]").val();

    var code = $("input[name=Code]").val();
    var Modulename = $("input[name=elemmodulename]").val();
    var prof = $("select[name=profname]").text();

    var form = $("#form-elem").serialize();

    if (
      semester != "" &&
      year != "" &&
      periode != "" &&
      code != "" &&
      Modulename != "" &&
      prof != ""
    ) {
      $.post(
        "controllers/module_element.php",
        {
          prof: prof.trim(),
          form: form,
          confirm_btn: "confirm_btn",
        },
        function (data) {
          console.log(data);

          // data = JSON.parse(data);
          // console.log(data);
        }
      );
    } else {
      alert("veulliez remplir tout les champs");
    }
  });
  $("div#for-teacher").hide();
  $("div#for-student").hide();
  //register
  $("input[name=type]").on("click", function () {
    var selectedValue = $("input[name=type]:checked").val();
    console.log(selectedValue);
    if (selectedValue == "T") {
      $("div#for-teacher").show();
      $("div#for-student").hide();
    } else if (selectedValue == "S") {
      $("div#for-student").show();
      $("div#for-teacher").hide();
    } else if (selectedValue == "A") {
      $("div#for-teacher").hide();
      $("div#for-student").hide();
    }
    var form = $("#form-register").serialize();
    console.log(form);
  });
  $("button[name=register-btn]").on("click", function (e) {
    e.preventDefault();

    var form = $("#form-register").serialize();
    console.log(form);
    $.post(
      "controllers/register.php",
      {
        register_form: "yes",
        form: form,
      },
      function (data) {
        console.log(data);

        // data = JSON.parse(data);
        // console.log(data);
      }
    );
  });
  // $("#submit-news-btn").on("click", function (e) {
  //   e.preventDefault();
  // });
  // $("a[class=link]").on("click", function () {

  // });
});
