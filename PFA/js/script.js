$(function () {
  // Same as document.addEventListener("DOMContentLoaded"...

  // Same as document.querySelector("#navbarToggle").addEventListener("blur",...
  $("#navbarToggle").blur(function (event) {
    var screenWidth = window.innerWidth;
    if (screenWidth < 768) {
      $("#collapsable-nav").collapse("hide");
    }
  });
});

(function (global) {
  var dc = {};
  var elements = [
    "#p_id",
    "#p_token",
    "#p_email",
    "#p_password",
    "#p_cin",
    "#p_f_name",
    "#p_s_name",
    "#p_sexe",
    "#p_adresse",
    "#p_city",
    "#p_country",
    "#p_birthday",
    "#p_birthplace",
    "#p_phone",
    "#p_type",
    "#p_year",
    "#p_field",
    "#p_cf",
  ];
  var bib_val = ["#p_f_name", "#p_s_name", "#p_text"];
  var infos = "snippets/infos.html";
  var firstpage = "snippets/login-about.html";
  var ecole = "snippets/ecole.html";
  var filieres = "snippets/filieres.html";
  var bienvenu = "snippets/bienvenu.html";
  var forgotpassword = "snippets/forgot_password.html";
  var password_message = "snippets/password_message.html";
  var profile = "snippets/profile.html";
  var chrono = "snippets/chrono.html";
  var edit_chrono = "snippets/edit-chrono.html";
  var bib = " snippets/bib.html ";
  var nav_student = "snippets/nav-student.html";
  var nav_admin = "snippets/nav-admin.html";
  var nav_cf = "snippets/nav-cf.html";
  var creationCompte = "snippets/creationCompte.html";
  var creationF = "snippets/creationF.html";
  var creationEM = "snippets/creationEM.html";
  var creationM = "snippets/creationM.html";
  var creationClass = "snippets/creationClass.html";
  var add_news = " snippets/add-new.html";
  var changeSeance = "snippets/changeSeance.html";
  var Request = "snippets/loadRequest.html";

  // Convenience function for inserting innerHTML for 'select'
  var insertHtml = function (selector, html) {
    var targetElem = document.querySelector(selector);
    targetElem.innerHTML = html;
  };

  // Show loading icon inside element identified by 'selector'.
  var showLoading = function (selector) {
    var html = "<div class='text-center'>";
    html += "<img src='images/ajax-loader.gif'></div>";
    insertHtml(selector, html);
  };

  /*load login-about*/
  document.addEventListener("DOMContentLoaded", function (event) {
    $(document).scrollTop($("html").offset().top);
    showLoading("#main-content");
    $ajaxUtils.sendGetRequest(
      firstpage,
      function (responseText) {
        document.querySelector("#main-content").innerHTML = responseText;
      },
      false
    );
  });
  /*load name*/
  document.addEventListener("DOMContentLoaded", function (event) {
    // On first load, show home view
    $(document).scrollTop($("html").offset().top);
    showLoading("#id-name");
    $.ajax({
      type: "POST",
      url: "snippets/controllers/authController.php",
      data: { type: "name" },
      success: function (response) {
        $("#id-name").html(response);
      },
      error: function (response) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            response.status +
            " " +
            response.statusText
        );
      },
    });
  });

  /*load navbar*/
  document.addEventListener("DOMContentLoaded", function (event) {
    $(document).scrollTop($("html").offset().top);
    showLoading("#connected-nav");
    $.ajax({
      type: "POST",
      url: "snippets/controllers/authController.php",
      data: { type: "nav" },
      success: function (response) {
        if (response == "student") {
          $ajaxUtils.sendGetRequest(
            nav_student,
            function (responseText) {
              document.querySelector("#connected-nav").innerHTML = responseText;
            },
            false
          );
        } else {
          if (response == "admin") {
            $ajaxUtils.sendGetRequest(
              nav_admin,
              function (responseText) {
                document.querySelector("#connected-nav").innerHTML =
                  responseText;
              },
              false
            );
          } else {
            if (response == "yes") {
              $ajaxUtils.sendGetRequest(
                nav_cf,
                function (responseText) {
                  document.querySelector("#connected-nav").innerHTML =
                    responseText;
                },
                false
              );
            } else {
              $ajaxUtils.sendGetRequest(
                nav_student,
                function (responseText) {
                  document.querySelector("#connected-nav").innerHTML =
                    responseText;
                },
                false
              );
            }
          }
        }
      },
      error: function (response) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            response.status +
            " " +
            response.statusText
        );
      },
    });
  });

  /*load login-about*/
  dc.loadhome = function () {
    $(document).scrollTop($("html").offset().top);
    if (window.location.href.indexOf("connected.php") == -1) {
      showLoading("#main-content");
      $ajaxUtils.sendGetRequest(
        firstpage,
        function (responseText) {
          document.querySelector("#main-content").innerHTML = responseText;
        },
        false
      );
    } else {
      showLoading("#main-content2");
      $ajaxUtils.sendGetRequest(
        bienvenu,
        function (responseText) {
          document.querySelector("#main-content2").innerHTML = responseText;
        },
        false
      );
    }
  };

  /*traite les données*/
  dc.login = function () {
    $(document).scrollTop($("html").offset().top);
    document.getElementById("type").value = "login";
    var form = $("#login");
    var str = form.serialize();
    $.ajax({
      type: "POST",
      url: "snippets/controllers/authController.php",
      data: str,
      async: false,
      success: function (response) {
        if (response == "connected.php") {
          window.location = "connected.php";
        } else {
          $("#errors").html(response);
        }
        // On first load, show home view
      },
      error: function (response) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            response.status +
            " " +
            response.statusText
        );
      },
    });
  };

  /*click on forgot_password*/
  dc.forgotPassword = function () {
    $(document).scrollTop($("html").offset().top);
    showLoading("#main-content");
    $ajaxUtils.sendGetRequest(
      forgotpassword,
      function (responseText) {
        document.querySelector("#main-content").innerHTML = responseText;
      },
      false
    );
  };

  /*click on recorver password*/
  dc.recover = function () {
    $(document).scrollTop($("html").offset().top);
    document.getElementById("type").value = "forgot-password";
    var form = $("#forgot-password-form");
    var str = form.serialize();
    $.ajax({
      type: "POST",
      url: "snippets/controllers/authController.php",
      data: str,
      success: function (response) {
        if (response == "password_message.html") {
          showLoading("#main-content");
          $ajaxUtils.sendGetRequest(
            firstpage,
            function (firstHtml) {
              document.querySelector("#main-content").innerHTML = firstHtml;
              $ajaxUtils.sendGetRequest(
                password_message,
                function (message) {
                  document.querySelector("#password-message").innerHTML =
                    message;
                },
                false
              );
            },
            false
          );
        } else {
          $("#errors-forgot-password").html(response);
        }
      },
      error: function (response) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            response.status +
            " " +
            response.statusText
        );
      },
    });
  };
  /*reset password*/
  dc.reset = function () {
    $(document).scrollTop($("html").offset().top);
    var path = window.location.href;
    var index = path.indexOf("=");
    var start = index + 1;
    var passwordtoken = path.substring(start, path.length);
    var password = $("input[name=password]").val();
    var passwordConf = $("input[name=passwordConf]").val();
    console.log(passwordtoken);
    $.ajax({
      type: "POST",
      url: "controllers/authController.php",
      data: {
        type: "reset-password",
        password_token: passwordtoken,
        password: password,
        passwordConf: passwordConf,
      },
      async: false,
      success: function (response) {
        if (response == "connected.php") {
          window.location = "../home.php";
        } else {
          $("#errors-reset-password").html(response);
        }
        // On first load, show home view
      },
      error: function (response) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            response.status +
            " " +
            response.statusText
        );
      },
    });
  };
  /*show/unshow reset*/
  dc.show_password_reset = function () {
    $(document).scrollTop($("html").offset().top);
    var text = document.getElementById("password-reset");
    if (text.type === "password") {
      text.type = "text";
      $("#show-icon2").removeClass("glyphicon-eye-close");
      $("#show-icon2").addClass("glyphicon-eye-open");
    } else {
      text.type = "password";
      $("#show-icon2").removeClass("glyphicon-eye-open");
      $("#show-icon2").addClass("glyphicon-eye-close");
    }
  };
  dc.show_conf_password_reset = function () {
    $(document).scrollTop($("html").offset().top);
    var text = document.getElementById("conf_password-reset");
    if (text.type === "password") {
      text.type = "text";
      $("#show-icon3").removeClass("glyphicon-eye-close");
      $("#show-icon3").addClass("glyphicon-eye-open");
    } else {
      text.type = "password";
      $("#show-icon3").removeClass("glyphicon-eye-open");
      $("#show-icon3").addClass("glyphicon-eye-close");
    }
  };

  /*bienvenu*/
  document.addEventListener("DOMContentLoaded", function (event) {
    $(document).scrollTop($("html").offset().top);
    // On first load, show home view
    showLoading("#main-content2");
    $ajaxUtils.sendGetRequest(
      bienvenu,
      function (responseText) {
        document.querySelector("#main-content2").innerHTML = responseText;
        showLoading("#id-name2");
        $.ajax({
          type: "POST",
          url: "snippets/controllers/authController.php",
          data: { type: "name" },
          success: function (response) {
            $("#id-name2").html(response);
          },
        });
      },
      false
    );
  });
  /*load bienvenu*/
  dc.loadBienvenu = function () {
    $(document).scrollTop($("html").offset().top);
    showLoading("#main-content2");
    $ajaxUtils.sendGetRequest(
      bienvenu,
      function (responseText) {
        document.querySelector("#main-content2").innerHTML = responseText;
        showLoading("#id-name2");
        $.ajax({
          type: "POST",
          url: "snippets/controllers/authController.php",
          data: { type: "name" },
          async: false,
          success: function (response) {
            $("#id-name2").html(response);
          },
          error: function (response) {
            $("#status").text(
              "Erreur pour poster le formulaire : " +
                response.status +
                " " +
                response.statusText
            );
          },
        });
      },
      false
    );
  };

  /*when u click on infos*/
  dc.loadInfos = function () {
    $(document).scrollTop($("html").offset().top);
    if (window.location.href.indexOf("connected.php") == -1) {
      showLoading("#main-content");
      $ajaxUtils.sendGetRequest(
        infos,
        function (responseText) {
          document.querySelector("#main-content").innerHTML = responseText;
        },
        false
      );
    } else {
      showLoading("#main-content2");
      $ajaxUtils.sendGetRequest(
        infos,
        function (responseText) {
          document.querySelector("#main-content2").innerHTML = responseText;
          $("#container").remove();
        },
        false
      );
    }
  };

  /*when u click on Ecole*/
  dc.loadEcole = function () {
    $(document).scrollTop($("html").offset().top);
    if (window.location.href.indexOf("connected.php") == -1) {
      showLoading("#main-content");
      $ajaxUtils.sendGetRequest(
        ecole,
        function (responseText) {
          document.querySelector("#main-content").innerHTML = responseText;
        },
        false
      );
    } else {
      showLoading("#main-content2");
      $ajaxUtils.sendGetRequest(
        ecole,
        function (responseText) {
          document.querySelector("#main-content2").innerHTML = responseText;
        },
        false
      );
    }
  };

  /*when u click on FILIERES*/
  dc.loadFilieres = function () {
    $(document).scrollTop($("html").offset().top);
    if (window.location.href.indexOf("connected.php") == -1) {
      showLoading("#main-content");
      $ajaxUtils.sendGetRequest(
        filieres,
        function (responseText) {
          document.querySelector("#main-content").innerHTML = responseText;
        },
        false
      );
    } else {
      showLoading("#main-content2");
      $ajaxUtils.sendGetRequest(
        filieres,
        function (responseText) {
          document.querySelector("#main-content2").innerHTML = responseText;
        },
        false
      );
    }
  };

  /*profile*/
  dc.loadProfile = function () {
    $(document).scrollTop($("html").offset().top);
    $.ajax({
      type: "POST",
      url: "snippets/controllers/authController.php",
      data: { type: "profile" },
      success: function (response) {
        showLoading("#main-content2");
        $ajaxUtils.sendGetRequest(
          profile,
          function (responseText) {
            document.querySelector("#main-content2").innerHTML = responseText;
            for (var i = 0; i < elements.length; i++) {
              $(elements[i]).html(response.split("\n")[i]);
              console.log(elements[i], response.split("\n")[i]);
            }
            if (response.split("\n")[14] == "<span>Admin</span>") {
              $("#year").hide();
              $("#field").hide();
              $("#p_biblio").hide();
              $("#cf").hide();
            }
            if (response.split("\n")[14] == "<span>Professeur</span>") {
              $("#year").hide();
              $("#field").hide();
              if (response.split("\n")[17] == "<span>non</span>") {
                $("#cf").hide();
              }
              $.ajax({
                type: "POST",
                url: "snippets/controllers/authController.php",
                data: { type: "bib-profile" },
                success: function (response2) {
                  $("#p_biblio p").html(response2);
                },
                error: function (response2) {
                  $("#status").text(
                    "Erreur pour poster le formulaire : " +
                      response2.status +
                      " " +
                      response2.statusText
                  );
                },
              });
            }
            if (response.split("\n")[14] == "<span>Etudiant</span>") {
              $("#p_biblio").hide();
              $("#cf").hide();
            }
          },
          false
        );
      },
      error: function (response) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            response.status +
            " " +
            response.statusText
        );
      },
    });
  };

  dc.edit = function () {
    if (
      document.getElementById("text-bib").getAttribute("contentEditable") ==
      "false"
    ) {
      document
        .getElementById("text-bib")
        .setAttribute("contentEditable", "true");
      $("#text-bib").addClass("box-shadow");
      $("#btn-edit").html("Sauvegarder");
    } else {
      var text = $("#text-bib").html();
      console.log(text);
      $.ajax({
        type: "POST",
        url: "snippets/controllers/authController.php",
        data: { type: "edit-bib", text: text },
        success: function (response) {
          document
            .getElementById("text-bib")
            .setAttribute("contentEditable", "false");
          $("#text-bib").removeClass("box-shadow");
          $("#btn-edit").html("Modifier");
        },
        error: function (response) {
          $("#status").text(
            "Erreur pour poster le formulaire : " +
              response.status +
              " " +
              response.statusText
          );
        },
      });
    }
  };

  /*logout*/
  dc.logout = function () {
    $(document).scrollTop($("html").offset().top);
    $.ajax({
      type: "POST",
      url: "snippets/controllers/authController.php",
      data: { type: "logout" },
      success: function (response) {
        if (response == "home.php") {
          window.location = "home.php";
        }
      },
      error: function (response) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            response.status +
            " " +
            response.statusText
        );
      },
    });
  };

  /*show/unshow password*/
  dc.show = function () {
    $(document).scrollTop($("html").offset().top);
    var text = document.getElementById("password");
    if (text.type === "password") {
      text.type = "text";
      $("#show-icon").removeClass("glyphicon-eye-close");
      $("#show-icon").addClass("glyphicon-eye-open");
    } else {
      text.type = "password";
      $("#show-icon").removeClass("glyphicon-eye-open");
      $("#show-icon").addClass("glyphicon-eye-close");
    }
  };

  /*load chrono*/
  dc.loadChrono = function () {
    $(document).scrollTop($("html").offset().top);
    showLoading("#main-content2");
    $ajaxUtils.sendGetRequest(
      chrono,
      function (responseText) {
        document.querySelector("#main-content2").innerHTML = responseText;
        var text = "<option disabled selected></option>";
        for (var x = 1; x <= 6; x++) {
          text += "<option value='" + x + "'>" + x + "</option>";
        }
        $("#week").html(text);
        $("#first-row").hide();
        $("#download-btn").hide();
      },
      false
    );
    $.ajax({
      type: "POST",
      url: "snippets/controllers/authController.php",
      data: { type: "profile" },
      success: function (response2) {
        var text = response2.split("\n")[15] + " " + response2.split("\n")[16];
        $("#chrono-filed").html(text);
      },
      error: function (response2) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            response2.status +
            " " +
            response2.statusText
        );
      },
    });
  };
  /* show chrono */
  dc.showChrono = function () {
    $(document).scrollTop($("#first-row").offset().top);
    var form = $("#form-chrono").serialize();
    $.ajax({
      type: "POST",
      url: "snippets/controllers/authController.php",
      data: { type: "chrono", form: form },
      success: function (response) {
        console.log(response);
        if (response != "ntg") {
          $("#first-row").show();
          $("#download-btn").show();
          $("#tabletime").html(response);
        }
      },
      error: function (response) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            response.status +
            " " +
            response.statusText
        );
      },
    });
  };

  /* uppload chorno */
  dc.image = function () {
    $(document).scrollTop($("#first-row").offset().top);
    html2canvas(document.getElementById("first-row"), {
      onrendered: function (canvas) {
        var imgData = canvas.toDataURL("image/png", 1.0);
        console.log("Report Image URL: " + imgData);
        var doc = new jsPDF("l", "mm", [320, 150]);
        doc.addImage(imgData, "PNG", 10, 10);
        doc.save("Emploi.pdf");
      },
    });
  };

  dc.editChrono = function () {
    $ajaxUtils.sendGetRequest(
      edit_chrono,
      function (responseText) {
        document.querySelector("#main-content2").innerHTML = responseText;
        var text = "<option disabled selected></option>";
        for (var x = 1; x <= 6; x++) {
          text += "<option value='" + x + "'>" + x + "</option>";
        }
        console.log(text);
        $("#week").html(text);
        $.ajax({
          type: "POST",
          url: "snippets/controllers/authController.php",
          data: { type: "profile" },
          success: function (response2) {
            $("#field").html(response2.split("\n")[17]);
          },
          error: function (response2) {
            $("#status").text(
              "Erreur pour poster le formulaire : " +
                response2.status +
                " " +
                response2.statusText
            );
          },
        });
        $ajaxUtils.sendGetRequest(
          "snippets/form-chrono.html",
          function (responseText2) {
            console.log(responseText2);
            document.querySelector("#form2").innerHTML = responseText2;
          },
          false
        );
      },
      false
    );
  };
  /*reload the editor of chrono*/
  dc.reload = function () {
    /*reset*/
    $ajaxUtils.sendGetRequest(
      "snippets/form-chrono.html",
      function (responseText) {
        document.querySelector("#form2").innerHTML = responseText;
        var form1 = $("#form1").serialize();
        $("option[class='option-seance']").remove();
        $("option[class='option-class']").remove();
        $.ajax({
          type: "POST",
          url: "snippets/controllers/authController.php",
          data: { type: "hhh", changeseance: "yes", form1: form1 },
          async: false,
          success: function (data) {
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
          },
          error: function (data) {
            $("#status").text(
              "Erreur pour poster le formulaire : " +
                data.status +
                " " +
                data.statusText
            );
          },
        });
        $.ajax({
          type: "POST",
          url: "snippets/controllers/authController.php",
          data: { type: "hhh", changeclass: "yes" },
          async: false,
          success: function (data) {
            data = JSON.parse(data);

            for (i = 1; i <= 4; i++) {
              for (var x of data) {
                var opttext = x["Type_class"];
                var optvalue = x["ID_class"];

                $("select[name=class" + i + "]").append(
                  $("<option>")
                    .val(optvalue)
                    .text(opttext)
                    .addClass("option-class")
                );
              }
            }
          },
          error: function (data) {
            $("#status").text(
              "Erreur pour poster le formulaire : " +
                data.status +
                " " +
                data.statusText
            );
          },
        });

        var semester = $("select[name=semester]").val();
        var year = $("select[name=year]").val();
        var periode = $("select[name=periode]").val();
        var date = $("input[name=date-emploi]").val();
        var form1 = $("#form1").serialize();
        var field = $("h1[id=field]").text();

        if (semester != "" && year != "" && periode != "" && date != "") {
          $.ajax({
            type: "POST",
            url: "snippets/controllers/authController.php",
            data: {
              type: "hhh",
              semester: semester,
              year: year,
              periode: periode,
              date: date,
              form1: form1,
            },
            async: false,
            success: function (data) {
              data = JSON.parse(data);
              for (var i = 0; i < data.length; i++) {
                if (
                  data[i]["year_s"] != year ||
                  data[i]["name_field"] != field
                ) {
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
                  console.log(data[i]["id_prof"]);
                  $(`select[name="seance${data[i]["seance_n"]}"]`).val(
                    data[i]["id_prof"]
                  );
                  $(`select[name="class${data[i]["seance_n"]}"]`).val(
                    data[i]["CLASS_S"]
                  );
                }
              }
            },
            error: function (data) {
              $("#status").text(
                "Erreur pour poster le formulaire : " +
                  data.status +
                  " " +
                  data.statusText
              );
            },
          });
        } else {
          alert("missing data");
        }
      },
      false
    );
  };
  /*confirm the edit of chrono*/
  dc.confirm_edit = function () {
    $(document).scrollTop($("html").offset().top);
    var semester = $("select[name=semester]").val();
    var year = $("select[name=year]").val();
    var periode = $("select[name=periode]").val();
    var field = $("span[id=field]").text();
    var form = $("#form1").serialize();
    form = form.concat($("#form2").serialize());
    //console.log(form);
    if (semester != "" && year != "" && periode != "") {
      console.log("fdsfs");
      $.post(
        "snippets/controllers/authController.php",
        {
          type: "hhhh",
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
  };

  /*load fields of news*/
  dc.loadNewsF = function (event) {
    $(document).scrollTop($("html").offset().top);
    $.ajax({
      type: "POST",
      url: "snippets/controllers/authController.php",
      data: { type: "profile" },
      success: function (response2) {},
      error: function (response2) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            response2.status +
            " " +
            response2.statusText
        );
      },
    });
    $.ajax({
      type: "POST",
      url: "snippets/controllers/authController.php",
      data: { type: "newsF", id: event.id },
      async: false,
      success: function (response) {
        if (window.location.href.indexOf("connected.php") == -1) {
          showLoading("#main-content");
          $("#main-content").html(response);
        } else {
          showLoading("#main-content2");
          $("#main-content2").html(response);
        }
      },
      error: function (response) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            response.status +
            " " +
            response.statusText
        );
      },
    });
  };

  /*load news*/
  dc.loadNews = function () {
    $(document).scrollTop($("html").offset().top);
    $.ajax({
      type: "POST",
      url: "snippets/controllers/authController.php",
      data: { type: "news" },
      async: false,
      success: function (response) {
        if (window.location.href.indexOf("connected.php") == -1) {
          showLoading("#main-content");
          $("#main-content").html(response);
        } else {
          showLoading("#main-content2");
          $("#main-content2").html(response);
        }
      },
      error: function (response) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            response.status +
            " " +
            response.statusText
        );
      },
    });
  };

  /*load news element*/
  dc.loadNewsE = function (argument) {
    $(document).scrollTop($("html").offset().top);
    var path = window.location.href;
    var index = path.indexOf("#");
    var start = index + 1;
    var field = path.substring(start, path.length);
    var id = argument.id.replace(/_/g, " ");
    console.log(id);
    $.ajax({
      type: "POST",
      url: "snippets/controllers/authController.php",
      data: { type: "newsE", field: field, id: id },
      async: false,
      success: function (response) {
        if (window.location.href.indexOf("connected.php") == -1) {
          response +=
            '</div><div id="container" style="margin-top: 70px;" ><div id="retour" style="margin-top: -30px;"><a href="#' +
            field +
            '" onclick="$dc.loadNewsF(' +
            field +
            ');" ><button id=' +
            field +
            ' type="button" class="btn btn-danger">RETOUR</button></a></div>';
          showLoading("#main-content");
          $("#main-content").html(response);
        } else {
          response +=
            '</div><div id="container" style="margin-top: 70px;" ><div id="retour" style="margin-top: -30px;"><a href="#' +
            field +
            '" onclick="$dc.loadNewsF(' +
            field +
            ');" ><button id=' +
            field +
            ' type="button" class="btn btn-danger">RETOUR</button></a></div>';
          if (response.split("\n")[0] == "<p id='iscf'>iscf<p>") {
            response +=
              ' <div id="supprimer" ><a href="#' +
              field +
              '" onclick="$dc.removeNews();" ><button type="button" class="btn btn-danger">SUPPRIMER</button></a></div>';
            response +=
              ' <div id="modifier" ><button onclick="$dc.changeNews();" type="button" id=\'modifier-btn\' class="btn btn-danger">MODIFIER</button></div>';
            showLoading("#main-content2");
            $("#main-content2").html(response.split("\n")[1]);
          } else {
            showLoading("#main-content2");
            $("#main-content2").html(response);
          }
        }
      },
      error: function (response) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            response.status +
            " " +
            response.statusText
        );
      },
    });
  };
  /*on remove news*/
  dc.removeNews = function () {
    $(document).scrollTop($("html").offset().top);
    var id = $("#title").html();
    $.post(
      "snippets/controllers/authController.php",
      {
        type: "removeNews",
        id: id,
      },
      function (data) {
        console.log(data);
        var event = { id: data };
        dc.loadNewsF(event);
      }
    );
  };
  /*change news */
  dc.changeNews = function () {
    if (
      document.getElementById("text").getAttribute("contentEditable") == "false"
    ) {
      $(document).scrollTop($("#header-container2").offset().top);
      document.getElementById("text").setAttribute("contentEditable", "true");
      $("#text").addClass("box-shadow").css("height", "100px");
      $("#modifier-btn").html("Sauvegarder");
    } else {
      var text = $("#text").html();
      var id = $("h3").html();
      $.ajax({
        type: "POST",
        url: "snippets/controllers/authController.php",
        data: { type: "changeNews", text: text, id: id },
        success: function (response) {
          document
            .getElementById("text")
            .setAttribute("contentEditable", "false");
          $("#text").removeClass("box-shadow");
          $("#modifier-btn").html("Modifier");
        },
        error: function (response) {
          $("#status").text(
            "Erreur pour poster le formulaire : " +
              response.status +
              " " +
              response.statusText
          );
        },
      });
    }
  };
  /* add new */
  dc.addNews = function () {
    $(document).scrollTop($("#header-container2").offset().top);
    showLoading("#main-content2");
    $ajaxUtils.sendGetRequest(
      add_news,
      function (responseText) {
        document.querySelector("#main-content2").innerHTML = responseText;
      },
      false
    );
  };
  /* confirm add new */
  dc.confirmAdd = function () {
    var text = $("#editor").html();
    var title = $("#form-news").serialize();
    console.log(title);
    if (title == "title=") {
      error =
        '<div style="padding : 6px;" class="alert alert-danger"><li>Un titre est necessaire</li></div>';
      $("#errors").html(error);
    } else {
      $.post(
        "snippets/controllers/authController.php",
        {
          type: "confirmAdd",
          title: title,
          content: text,
        },
        function (data) {
          console.log(data);
          console.log("dsf");

          var event = { id: data };
          dc.loadNewsF(event);
        }
      );
    }
  };

  dc.loadProf = function () {
    $(document).scrollTop($("html").offset().top);
    $.ajax({
      type: "POST",
      url: "snippets/controllers/authController.php",
      data: { type: "prof" },
      async: false,
      success: function (response) {
        response +=
          '</div><div id="container" style="margin-top: 70px;" ><div id="retour" style="margin-top: -30px;"><a href="#infos" onclick="$dc.loadInfos();" ><button  type="button" class="btn btn-danger">RETOUR</button></a></div>';
        if (window.location.href.indexOf("connected.php") == -1) {
          showLoading("#main-content");
          $("#main-content").html(response);
        } else {
          showLoading("#main-content2");
          $("#main-content2").html(response);
        }
      },
      error: function (response) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            response.status +
            " " +
            response.statusText
        );
      },
    });
  };

  dc.loadBib = function (event) {
    $(document).scrollTop($("html").offset().top);
    $.ajax({
      type: "POST",
      url: "snippets/controllers/authController.php",
      data: { type: "bib", id: event },
      async: false,
      success: function (response) {
        if (window.location.href.indexOf("connected.php") == -1) {
          showLoading("#main-content");
          $ajaxUtils.sendGetRequest(
            bib,
            function (responseText) {
              responseText +=
                '</div><div id="container" style="margin-top: 70px;" ><div id="retour" style="margin-top: -30px;"><a href="#infos" onclick="$dc.loadProf();" ><button  type="button" class="btn btn-danger">RETOUR</button></a></div>';
              document.querySelector("#main-content").innerHTML = responseText;
              for (var i = 0; i < response.split("\n").length; i++) {
                $(bib_val[i]).html(response.split("\n")[i]);
              }
            },
            false
          );
        } else {
          showLoading("#main-content2");
          $ajaxUtils.sendGetRequest(
            bib,
            function (responseText) {
              responseText +=
                '</div><div id="container" style="margin-top: 70px;" ><div id="retour" style="margin-top: -30px;"><a href="#infos" onclick="$dc.loadProf();" ><button  type="button" class="btn btn-danger">RETOUR</button></a></div>';
              document.querySelector("#main-content2").innerHTML = responseText;
              for (var i = 0; i < response.split("\n").length; i++) {
                $(bib_val[i]).html(response.split("\n")[i]);
              }
            },
            false
          );
        }
      },
      error: function (response) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            response.status +
            " " +
            response.statusText
        );
      },
    });
  };

  /*load creation of user page*/
  dc.loadCreationCompte = function () {
    $(document).scrollTop($("html").offset().top);
    showLoading("#main-content2");
    $ajaxUtils.sendGetRequest(
      creationCompte,
      function (responseText) {
        document.querySelector("#main-content2").innerHTML = responseText;
        // $("div#for-teacher").hide();
        $("div#for-student").hide();
      },
      false
    );
  };
  /*create a user*/
  dc.createCompte = function () {
    $(document).scrollTop($("html").offset().top);
    document.getElementById("type").value = "createCompte";
    var form = $("#form-register");
    var str = form.serialize();
    console.log($(".sexe:checked").val());
    $.ajax({
      type: "POST",
      url: "snippets/controllers/authController.php",
      data: str,
      async: false,
      success: function (response) {
        console.log(response);
        if (response == "createCompte") {
          var text =
            "<h3 style='text-align: center;margin-bottom: 35px;'>Un compte a été créé avec succés</h3>";
          $("#main-content2").html(text);
        } else {
          $("#errors").html(response);
        }
      },
      error: function (response) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            response.status +
            " " +
            response.statusText
        );
      },
    });
  };

  /*load creation field */
  dc.loadCreationF = function () {
    $(document).scrollTop($("html").offset().top);
    showLoading("#main-content2");
    $ajaxUtils.sendGetRequest(
      creationF,
      function (responseText) {
        document.querySelector("#main-content2").innerHTML = responseText;
        $.post(
          "snippets/controllers/authController.php",
          {
            type: "chooseTeacher",
          },
          function (data) {
            data = JSON.parse(data);
            for (var x of data) {
              var optText = x["name"];
              var optValue = x["ID_T"];
              $("select[name='prof']").append(
                $("<option>").val(optValue).text(optText)
              );
              $("select[name='prof2']").append(
                $("<option>").val(optValue).text(optText)
              );
            }
          }
        );
        $.post(
          "snippets/controllers/authController.php",
          {
            type: "chooseField2",
          },
          function (data) {
            console.log(data);
            data = JSON.parse(data);
            for (var x of data) {
              var optText = x["NAME_F"];
              $("select[name='field']").append(
                $("<option>").val(optText).text(optText)
              );
            }
          }
        );
      },
      false
    );
  };
  /* create a field */
  dc.createF = function () {
    var form = $("#form-adding-field").serialize();
    // console.log(form);
    $.post(
      "snippets/controllers/authController.php",
      {
        type: "createF",
        form: form,
      },
      function (data) {
        if (data == "") {
          var text =
            "<h3 style='text-align: center;margin-bottom: 35px;'>Une filiere a été créée avec succés</h3>";
          $("#main-content2").html(text);
          $(document).scrollTop($("html").offset().top);
        } else {
          $("#errors").html(data);
        }
      }
    );
  };
  /* modify a field */
  dc.modifyF = function () {
    var form = $("#form-adding-field2").serialize();
    // console.log(form);
    $.post(
      "snippets/controllers/authController.php",
      {
        type: "modifyF",
        form: form,
      },
      function (data) {
        if (data == "") {
          var text =
            "<h3 style='text-align: center;margin-bottom: 35px;'>Une filiere a été modifiée avec succés</h3>";
          $("#main-content2").html(text);
          $(document).scrollTop($("html").offset().top);
        } else {
          $("#errors2").html(data);
        }
      }
    );
  };

  /*load creation of module */
  dc.loadCreationM = function () {
    $(document).scrollTop($("html").offset().top);
    showLoading("#main-content2");
    $ajaxUtils.sendGetRequest(
      creationM,
      function (responseText) {
        document.querySelector("#main-content2").innerHTML = responseText;
      },
      false
    );
  };
  /*create M*/
  dc.createM = function () {
    var form = $("#form-module").serialize();
    console.log(form);
    if (form == "mName=") {
      error =
        '<div style="padding : 6px;" class="alert alert-danger"><li>Entrez un nom pour le module</li></div>';
      $("#errors").html(error);
    } else {
      $.post(
        "snippets/controllers/authController.php",
        {
          type: "createM",
          form: form,
        },
        function (data) {
          if (data == "good") {
            var text =
              "<h3 style='text-align: center;margin-bottom: 35px;'>Un module a été créé avec succés</h3>";
            $("#main-content2").html(text);
          } else {
            $("#errors").html(data);
          }
        }
      );
    }
  };

  /*load creation of Element of module */
  dc.loadCreationEM = function () {
    $(document).scrollTop($("html").offset().top);
    showLoading("#main-content2");
    $ajaxUtils.sendGetRequest(
      creationEM,
      function (responseText) {
        document.querySelector("#main-content2").innerHTML = responseText;
        $.post(
          "snippets/controllers/authController.php",
          {
            type: "chooseTeacherAll",
          },
          function (data) {
            data = JSON.parse(data);
            for (var x of data) {
              var optText = x["name"];
              var optValue = x["ID_T"];
              $("select[name='profname']").append(
                $("<option>").val(optValue).text(optText).addClass("prof_name")
              );
            }
          }
        );
        $.post(
          "snippets/controllers/authController.php",
          {
            type: "chooseModule",
          },
          function (data) {
            data = JSON.parse(data);
            for (var x of data) {
              var optText = x["NAME_M"];
              $("select[name='Code']").append(
                $("<option>").val(optText).text(optText)
              );
            }
          }
        );
      },
      false
    );
  };
  /*create a EM */
  dc.createEM = function () {
    var form = $("#form-elem").serialize();
    console.log(form);
    $.post(
      "snippets/controllers/authController.php",
      {
        type: "createEM",
        form: form,
      },
      function (data) {
        console.log(data);
        if (data == "") {
          var text =
            "<h3 style='text-align: center;margin-bottom: 35px;'>Un elment de module a été créé avec succés</h3>";
          $("#main-content2").html(text);
        } else {
          $("#errors").html(data);
        }
      }
    );
  };

  /*show teacher space in creation*/
  // dc.showTeacher = function () {
  //   $("div#for-student").hide();
  //   $("div#for-teacher").show();
  // };

  /*show student space in creation*/
  dc.showStudent = function () {
    // $("div#for-teacher").hide();
    $("div#for-student").show();
    $.post(
      "snippets/controllers/authController.php",
      {
        type: "chooseField",
      },
      function (data) {
        var text = "<option disabled selected></option>";
        for (i = 0; i < data.split("\n").length - 1; i++) {
          text +=
            "<option value='" +
            data.split("\n")[i] +
            "'>" +
            data.split("\n")[i] +
            "</option>";
        }
        $("#field").html(text);
      }
    );
  };

  /*show admin space in creation*/
  dc.showNone = function () {
    // $("div#for-teacher").hide();
    $("div#for-student").hide();
  };

  /*load creation class */
  dc.loadCreationClass = function () {
    $(document).scrollTop($("html").offset().top);
    showLoading("#main-content2");
    $ajaxUtils.sendGetRequest(
      creationClass,
      function (responseText) {
        document.querySelector("#main-content2").innerHTML = responseText;
      },
      false
    );
  };
  /* create a class */
  dc.createClass = function () {
    var form = $("#form-class").serialize();
    $.post(
      "snippets/controllers/authController.php",
      {
        type: "createClass",
        form: form,
      },
      function (data) {
        console.log(data);
        if (data == "") {
          var text =
            "<h3 style='text-align: center;margin-bottom: 35px;'>Une classe a été créée avec succés</h3>";
          $("#main-content2").html(text);
        } else {
          $("#errors").html(data);
        }
      }
    );
  };

  /*load suppresion*/
  dc.loadSuppression = function () {
    $(document).scrollTop($("html").offset().top);
    $.ajax({
      type: "POST",
      url: "snippets/controllers/authController.php",
      data: { type: "suppression" },
      async: false,
      success: function (response) {
        showLoading("#main-content2");
        $("#main-content2").html(response);
      },
      error: function (response) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            response.status +
            " " +
            response.statusText
        );
      },
    });
  };
  /*clicked on user*/
  dc.clicked = function (event) {
    console.log(event.id);
    console.log(document.getElementById(event.id).getAttribute("value"));
    if (document.getElementById(event.id).getAttribute("value") == "no") {
      $("#" + event.id + " #user-title").addClass("box");
      document.getElementById(event.id).setAttribute("value", "yes");
    } else {
      $("#" + event.id + " #user-title").removeClass("box");
      document.getElementById(event.id).setAttribute("value", "no");
    }
  };

  /*remove users*/
  dc.loadRemove = function () {
    var elements = ["ntg"];
    var j = 0;
    $.ajax({
      type: "POST",
      url: "snippets/controllers/authController.php",
      data: { type: "getremove" },
      async: false,
      success: function (response) {
        for (var i = 0; i < response.split("\n").length - 1; i++) {
          console.log(response.split("\n")[i]);
          if (
            document
              .getElementById(response.split("\n")[i])
              .getAttribute("value") == "yes"
          ) {
            elements[j] = document
              .getElementById(response.split("\n")[i] + "2")
              .getAttribute("value");
            j++;
          }
          console.log(response.split("\n")[i]);
        }
        $.ajax({
          type: "POST",
          url: "snippets/controllers/authController.php",
          data: { type: "remove", elements: elements },
          async: false,
          success: function (response2) {
            console.log(response2);
            dc.loadSuppression();
            $(document).scrollTop($("html").offset().top);
            if (response2 != "") {
              $("#errors").html(response2);
            }
          },
          error: function (response2) {
            $("#status").text(
              "Erreur pour poster le formulaire : " +
                response2.status +
                " " +
                response2.statusText
            );
          },
        });
      },
      error: function (response) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            response.status +
            " " +
            response.statusText
        );
      },
    });
  };
  //
  // <?php for ($x = 1; $x <= 6; $x++) : ?>
  //
  // <?php endfor ?>
  /* load edit seance */
  dc.loadSeance = function (event) {
    $(document).scrollTop($("html").offset().top);
    showLoading("#main-content2");
    $ajaxUtils.sendGetRequest(
      changeSeance,
      function (responseText) {
        document.querySelector("#main-content2").innerHTML = responseText;
        var text = "<option disabled selected></option>";
        for (var x = 1; x <= 6; x++) {
          text += "<option value=" + x + ">" + x + "</option>";
        }
        document.getElementById("id").setAttribute("value", event);
        $("#week").html(text);
        $("#form-reprogrammation").hide();
      },
      false
    );
  };
  /* show reprogrammation seance */
  dc.showReprogrammation = function () {
    $("#form-reprogrammation").show();
    var id = document.getElementById("id").getAttribute("value");
    $.ajax({
      type: "POST",
      url: "snippets/controllers/authController.php",
      data: { type: "showReprogrammation", id: id },
      async: false,
      success: function (data) {
        var week = data.split("\n")[0];
        var day = data.split("\n")[1];
        var num = data.split("\n")[2];
        $(`select[name="day"]`).val(day);
        $(`select[name="week"]`).val(week);
        var time = [
          "09:00 -> 10:40",
          "10:50 -> 12:30",
          "14:00 -> 15:40",
          "16:10 -> 17:50",
        ];
        for (var x = 0; x < 4; x++) {
          var optText = time[x];
          $("select[name=heure]").append(
            $("<option>")
              .val(x + 1)
              .text(optText)
              .addClass("option-time")
          );
        }
        $(`select[name="heure"]`).val(num);
        dc.showTime();
      },
      error: function (data) {
        $("#status").text(
          "Erreur pour poster le formulaire : " +
            data.status +
            " " +
            data.statusText
        );
      },
    });
  };
  /* unshow reprogrammation */
  dc.unshowReprogrammation = function () {
    $("#form-reprogrammation").hide();
  };

  /* color the time */
  dc.showTime = function () {
    var id = document.getElementById("id").getAttribute("value");
    var form = $("#form-reprogrammation").serialize();
    $(".option-time").attr("disabled", false).css("color", "black");
    $.post(
      "snippets/controllers/authController.php",
      {
        form: form,
        id: id,
        type: "showTime",
      },
      function (data) {
        console.log(data);
        data = JSON.parse(data);
        console.log(data);
        for (var x of data) {
          var optValue = x["seance_n"];
          $(`select[name="heure"] option[value ='${optValue}']`)
            .attr("disabled", true)
            .css("color", "red");
        }
      }
    );
  };

  dc.sendRequest = function () {
    var id = document.getElementById("id").getAttribute("value");
    var form = $("#form-reprogrammation").serialize();
    $.post(
      "snippets/controllers/authController.php",
      {
        form: form,
        id: id,
        type: "sendRequest",
      },
      function (data) {
        $("#main-content2").html(
          "<h2 class='text-center'>Votre demande a été envoyée avec succés</h2><br/>"
        );
      }
    );
  };
  /*load request for CF */
  dc.loadRequest = function () {
    var id;
    var html = "<h2 class='text-center'>Demandes</h2>  <br />";
    var time = [
      "09:00 -> 10:40",
      "10:50 -> 12:30",
      "14:00 -> 15:40",
      "16:10 -> 17:50",
    ];
    $.post("snippets/controllers/authController.php", {
      type: "profile",
    });
    $ajaxUtils.sendGetRequest(
      Request,
      function (responseText) {
        $.post(
          "snippets/controllers/authController.php",
          {
            type: "loadRequest",
          },
          function (data) {
            data = JSON.parse(data);
            if (data.length == 0) {
              html += "<h3>Aucune demande n'existe </h3>";
            }
            for (var x of data) {
              var id_r = x["ID_req"];
              id = id_r;
              var em = x["NAME_elem_M"];
              var B_week = x["week"];
              var A_week = x["week_r"];
              var B_day = x["day_"];
              var A_day = x["day_r"];
              var B_time = x["seance_n"];
              var A_time = x["seance_n_r"];
              var year = x["year_s"];
              console.log(x["type"]);
              if (x["type"] == "A") {
                var text =
                  "<div class='form-group'><h4 id='em' class='text-center'>" +
                  em +
                  "&nbsp;&nbsp;Annulation</h4></div><div class='row'><div class='col-md-4'></div><div class='col-md-2'><div class='form-group'><button type='button'id='login-btn'onclick='$dc.acceptRequestD(" +
                  id_r +
                  ");'name='register-btn'class='btn btn-primary btn-block btn-lg'>Accepter</button></div></div><div class='col-md-2'><div class='form-group'><button type='button'id='login-btn'onclick='$dc.refuseRequest(" +
                  id_r +
                  ");'name='register-btn'class='btn btn-primary btn-block btn-lg'>Refuser</button></div></div></div>";
                $("#main-content2").html(text);
              } else {
                $("#main-content2").html(responseText);
                em = em + "&nbsp;&nbsp;Reprogrammation";
                $("#em").html(em);
                document.querySelector("#form").id = "r" + id_r;
                document.querySelector("#B_week").setAttribute("value", B_week);
                document.querySelector("#A_week").setAttribute("value", A_week);
                document.querySelector("#B_day").setAttribute("value", B_day);
                document.querySelector("#A_day").setAttribute("value", A_day);
                document.querySelector("#year").setAttribute("value", year);
                document
                  .querySelector("#B_time")
                  .setAttribute("value", time[B_time - 1]);
                document
                  .querySelector("#A_time")
                  .setAttribute("value", time[A_time - 1]);
                document
                  .querySelector("#accept-btn")
                  .setAttribute("onclick", "$dc.acceptRequest(" + id_r + ");");
                document
                  .querySelector("#refuse-btn")
                  .setAttribute("onclick", "$dc.refuseRequest(" + id_r + ");");
                $.post(
                  "snippets/controllers/authController.php",
                  {
                    type: "showClass",
                  },
                  function (data2) {
                    data2 = JSON.parse(data2);
                    $("select[name=class]").append(
                      $("<option selected disabled>")
                    );
                    for (var x of data2) {
                      $("select[name=class]").append(
                        $("<option>").val(x["ID_class"]).text(x["Type_class"])
                      );
                    }
                  }
                );
                $.post(
                  "snippets/controllers/authController.php",
                  {
                    type: "colorClass",
                    id: id,
                  },
                  function (data2) {
                    data2 = JSON.parse(data2);
                    for (var x of data2) {
                      var optValue = x["CLASS_S"];
                      $(`select[name="class"] option[value ='${optValue}']`)
                        .attr("disabled", true)
                        .css("color", "red");
                    }
                  }
                );
              }
              html += $("#main-content2").html();
            }
            $("#main-content2").html(html);
          }
        );
      },
      false
    );
  };
  /*accept the request */
  dc.acceptRequest = function (event) {
    var id_form = "#r" + event;
    var form = $(id_form).serialize();
    if (form == "") {
      error = 
        '<div style="padding : 6px;" class="alert alert-danger"><li>Chosissez une classe</li></div>';
      $("#errors").html(error);
    } else {
      $.post(
        "snippets/controllers/authController.php",
        {
          type: "acceptRequest",
          id: event,
          form: form,
        },
        function (data) {
          console.log(data);
        }
      );
      dc.loadRequest();
    }
    $(document).scrollTop($("#header-container2").offset().top);
  };
  /*accepte delete request */
  dc.acceptRequestD = function (event) {
    $.post(
      "snippets/controllers/authController.php",
      {
        type: "acceptRequestD",
        id: event,
      },
      function (data) {
        console.log(data);
      }
    );
    dc.loadRequest();
    $(document).scrollTop($("#header-container2").offset().top);
  };
  /*refuse the request */
  dc.refuseRequest = function (event) {
    $.post("snippets/controllers/authController.php", {
      type: "refuseRequest",
      id: event,
    });
    dc.loadRequest();
    $(document).scrollTop($("#header-container2").offset().top);
  };

  global.$dc = dc;
})(window);
/*
$.ajax({
  type: "POST",
  url: "snippets/controllers/authController.php",
  data: { },
  async : false ,
  success: function (data) {
},
  error: function (data) {
     $("#status").text(
          "Erreur pour poster le formulaire : " +
            data.status +
            " " +
            data.statusText
        );
  },
});
*/
