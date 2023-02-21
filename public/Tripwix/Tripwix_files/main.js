var namevalue = '';
var propertyName = '';
var availabilityType = '';
var availabilityLink = '';
var priceDetails = '';
var comment = '';
var price_1 = '';
var from_1 = '';
var to_1 = '';
var mn_1 = '';
var season_1 = '';

var price_2 = '';
var from_2 = '';
var to_2 = '';
var mn_2 = '';
var season_2 = '';

var price_3 = '';
var from_3 = '';
var to_3 = '';
var mn_3 = '';
var season_3 = '';

var price_4 = '';
var from_4 = '';
var to_4 = '';
var mn_4 = '';
var season_4 = '';

var price_5 = '';
var from_5 = '';
var to_5 = '';
var mn_5 = '';
var season_5 = '';

var price_6 = '';
var from_6 = '';
var to_6 = '';
var mn_6 = '';
var season_6 = '';

var price_7 = '';
var from_7 = '';
var to_7 = '';
var mn_7 = '';
var season_7 = '';

var price_8 = '';
var from_8 = '';
var to_8 = '';
var mn_8 = '';
var season_8 = '';

var price_9 = '';
var from_9 = '';
var to_9 = '';
var mn_9 = '';
var season_9 = '';

var price_10 = '';
var from_10 = '';
var to_10 = '';
var mn_10 = '';
var season_10 = '';


var from1 = '';
var to1 = '';
var from2 = '';
var to2 = '';
var from3 = '';
var to3 = '';
var from4 = '';
var to4 = '';
var from5 = '';
var to5 = '';
var from6 = '';
var to6 = '';
var from7 = '';
var to7 = '';
var from8 = '';
var to8 = '';
var from9 = '';
var to9 = '';
var from10 = '';
var to10 = '';

var countDelete = 0;

$(function () {
    $("#get_started").click(function () {
        $("#right_side").fadeOut(400, function () {
            $(this).html("<div class='one_three_text'>            <p class='step_text' >Step 1/3</p>            <h2 class='heading_one_three' >Please tell us</h2>        </div>        <div class='step_content '>            <form class='form'>                <div class='form-group'><label for='name'>Your Name</label><input type='text' class='form-control' id='name' value placeholder='Your Name'></div>                <div class='form-group grp_second'><label for='propertyName'>Property Name</label><input                        type='text' class='form-control' id='propertyName' placeholder='Property Name'></div>            </form>            <div class='button'><button class='btn btn_main' id='continue1'                    onclick='continue1()'>Continue</button></div>        </div>").fadeIn(400);
        });
    });
});

function continue1() {
    from1 = ''; to1 = ''; from2 = ''; to2 = ''; from3 = ''; to3 = '';
    from4 = ''; to4 = ''; from5 = ''; to5 = ''; from6 = ''; to6 = ''; from7 = '';
    to7 = ''; from8 = ''; to8 = ''; from9 = ''; to9 = ''; from10 = ''; to10 = '';

    price_1 = '';mn_1 = '';season_1 = '';price_2 = '';mn_2 = '';season_2 = '';price_3 = '';mn_3 = '';season_3 = '';
    price_4 = '';mn_4 = '';season_4 = '';price_5 = '';mn_5 = '';season_5 = '';price_6 = '';mn_6 = '';season_6 = '';
    price_7 = '';mn_7 = '';season_7 = '';price_8 = '';mn_8 = '';season_8 = '';price_9 = '';mn_9 = '';season_9 = '';price_10 = '';
    mn_10 = '';season_10 = '';

    from_1 = ''; to_1 = ''; from_2= ''; to_2 = ''; from_3 = ''; to_3 = ''; from_4 = ''; to_4 = '';
    from_5 = ''; to_5 = ''; from_6 =''; to_6 = ''; from_7 = ''; to_7 = ''; from_8 = ''; to_8 = '';
    from_9= ''; to_9 = ''; from_10 = ''; to_10 = ''; countDelete = 0;

    namevalue = document.getElementById("name").value;
    propertyName = document.getElementById("propertyName").value;

    if (namevalue === "" || propertyName === "") {
        document.getElementById("name").style.border ="1px solid red";
        document.getElementById("propertyName").style.border ="1px solid red";
    }
    else {
        console.log()
        $("#right_side").fadeOut(400, function () {
            $(this).html('<div class="one_three_text"> <img src="./Tripwix_files/back.png" class="back-arrow" onclick="stepPrice(namevalue, propertyName)"> <p class="step_text">Step 2/3</p> <h2 class="heading_one_three">Prices</h2></div>  <div class="step_content">          <div>  <div class="prices" id="prices"> </div>            <div class="addbtn"> <button class="add_price_btn btnopenprice" id="addpricemodel"  data-toggle="modal" data-target="#exampleModalCenter"><span>+ &nbsp&nbsp&nbsp</span> Add                    Price</button> </div>   </div>         <div class="button"> <button class="btn btn_main" id="continue2"                    onclick="continue2()">Continue</button> </div>        </div>').fadeIn(400);
        });
    }
}

function validateNumber(input) {
    if (!/^\d+$/.test(input.value)) {
      input.style.border = "1px solid red";
    } else {
      input.style.border = "";
    }
  }

document.getElementById("price").addEventListener("input", function (event) {
    var regex = /^[0-9]+$/;
    if (!event.target.value.match(regex)) {
        event.target.value = event.target.value.substring(0, event.target.value.length - 1);
    }
    });

var count_prices = 0;


function addprice() {
    var redPriceBorder = document.getElementById("addpricemodel");
    redPriceBorder.classList.remove('red');
    var inputNumber = document.getElementById("price");
    var startDate = document.getElementById("fromDate");
    var endDate = document.getElementById("toDate");
    var select1 = document.getElementById("nights");
    var select2 = document.getElementById("season");
    var exampleModalCenter = document.querySelector(".modal");
    var modalBackDrop = document.querySelector(".backshadow");


    var date_from = document.getElementById('fromDate').value;
    var date_to = document.getElementById('toDate').value;
    var price = document.getElementById('price').value;
    var min_nit = document.getElementById('nights').value;
    var season = document.getElementById('season').value;

    if(date_from === "" || date_to === ""){
        startDate.classList.add('error');
        endDate.classList.add('error');
        exampleModalCenter.classList.add('open');
        exampleModalCenter.classList.add('show');
        modalBackDrop.classList.add('open');
    }
    if(!/^\d+$/.test(inputNumber.value)){
        inputNumber.classList.add('error');
        exampleModalCenter.style.display = "block";
        exampleModalCenter.classList.add('open');
        exampleModalCenter.classList.add('show');
        modalBackDrop.classList.add('open');
            return false;
    }
    if(price === ""){
        inputNumber.classList.add('error');
        exampleModalCenter.style.display = "block";
        exampleModalCenter.classList.add('open');
        exampleModalCenter.classList.add('show');
        modalBackDrop.classList.add('open');
    }
    if(min_nit === ""){
        select1.classList.add('error');
        exampleModalCenter.style.display = "block";
        exampleModalCenter.classList.add('open');
        exampleModalCenter.classList.add('show');
        modalBackDrop.classList.add('open');
    }
    if(season === ""){
        select2.classList.add('error');
        exampleModalCenter.style.display = "block";
        exampleModalCenter.classList.add('open');
        exampleModalCenter.classList.add('show');
        modalBackDrop.classList.add('open');
    }


    count_prices = count_prices + 1;
    if (count_prices <= 20) {
        var date_from = document.getElementById('fromDate').value;
        var date_to = document.getElementById('toDate').value;
        var price = document.getElementById('price').value;
        var min_nit = document.getElementById('nights').value;
        var season = document.getElementById('season').value;
        if (date_from === "" || date_to === "" || price === "" || min_nit === "" || season === "") {

        }
        else {

            if (count_prices == 1 || price_1 == '' && from_1 == '' && to_1 == '' && mn_1 == '' && season_1 == '') {
                price_1 = price;
                from_1 = date_from;
                to_1 = date_to;
                mn_1 = min_nit;
                season_1 = season;
                countDelete = 1;
            }
            else if (count_prices == 2 || price_2 == '' && from_2 == '' && to_2 == '' && mn_2 == '' && season_2 == '') {
                price_2 = price;
                from_2 = date_from;
                to_2 = date_to;
                mn_2 = min_nit;
                season_2 = season;
                countDelete = 2;
            }
            else if (count_prices == 3 || price_3 == '' && from_3 == '' && to_3 == '' && mn_3 == '' && season_3 == '') {
                price_3 = price;
                from_3 = date_from;
                to_3 = date_to;
                mn_3 = min_nit;
                season_3 = season;
                countDelete = 3;
            }
            else if (count_prices == 4 || price_4 == '' && from_4 == '' && to_4 == '' && mn_4 == '' && season_4 == '') {
                price_4 = price;
                from_4 = date_from;
                to_4 = date_to;
                mn_4 = min_nit;
                season_4 = season;
                countDelete = 4;
            }
            else if (count_prices == 5 || price_5 == '' && from_5 == '' && to_5 == '' && mn_5 == '' && season_5 == '') {
                price_5 = price;
                from_5 = date_from;
                to_5 = date_to;
                mn_5 = min_nit;
                season_5 = season;
                countDelete = 5;

            }
            else if (count_prices == 6 || price_6 == '' && from_6 == '' && to_6 == '' && mn_6 == '' && season_6 == '') {
                price_6 = price;
                from_6 = date_from;
                to_6 = date_to;
                mn_6 = min_nit;
                season_6 = season;
                countDelete = 6;

            }
            else if (count_prices == 7 || price_7 == '' && from_7 == '' && to_7 == '' && mn_7 == '' && season_7 == '') {
                price_7 = price;
                from_7 = date_from;
                to_7 = date_to;
                mn_7 = min_nit;
                season_7 = season;
                countDelete = 7;

            }
            else if (count_prices == 8 || price_8 == '' && from_8 == '' && to_8 == '' && mn_8 == '' && season_8 == '') {
                price_8 = price;
                from_8 = date_from;
                to_8 = date_to;
                mn_8 = min_nit;
                season_8 = season;
                countDelete = 8;
            }
            else if (count_prices == 9 || price_9 == '' && from_9 == '' && to_9 == '' && mn_9 == '' && season_9 == '') {
                price_9 = price;
                from_9 = date_from;
                to_9 = date_to;
                mn_9 = min_nit;
                season_9 = season;
                countDelete = 9;
            }
            else if (count_prices == 10 || price_10 == '' && from_10 == '' && to_10 == '' && mn_10 == '' && season_10 == '') {
                price_10 = price;
                from_10 = date_from;
                to_10 = date_to;
                mn_10 = min_nit;
                season_10 = season;
                countDelete = 10;

            }
            $("#prices").append('<div class="priceItem">            <div class="row">                <div class="date"> <span>' + date_from + '</span> <span>-</span><span> ' + date_to + ' </span>                    <p class="date_p" style="font-size: 12px; margin: 0; padding: 0; height: 16px;">' + price +
                        ' </p> <span class="date_season"                        style="color: rgba(0, 0, 0, 0.5); text-transform: uppercase; font-size: 12px; margin: 0; padding: 0;">'
                        + season + '</span>                </div>                <div class="icon"><i class="bi bi-calendar3"></i> <p data-index="' + countDelete +'" class="delete-price" onclick="deletePrice(event)">Delete</p></div>            </div>        </div>');

            exampleModalCenter.classList.remove('open');
            exampleModalCenter.classList.remove('show');
            modalBackDrop.classList.remove('open');
            exampleModalCenter.style.display = "none";

            endDate.classList.remove('error');
            startDate.classList.remove('error');
            inputNumber.classList.remove('error');
            select1.classList.remove('error');
            select2.classList.remove('error');

            inputNumber.value = "";
            startDate.value = "";
            endDate.value = "";
            select1.value = "";
            select2.value = "Low Season";

            convertDate();
     
            console.log(from_1, to_1)
            console.log(from_2, to_2)
            console.log(from_3, to_3)
            console.log(from_4, to_4)


        }
    }
    else {
        $('#addprice').attr('disabled', 'disabled');
    }
}

function continue2() {

    if (count_prices == 0 || from_1 == '' && from_2 == '' && from_3 == '' && from_4 == '' && from_5 == '' && 
        from_6 == '' && from_7 == '' && from_8 == '' && from_9 == '' && from_10 == '' && to_1 == '' && to_2 == '' &&
        to_3 == '' && to_4 == '' && to_5 == '' && to_6 == '' & to_7 == '' && to_8 == '' && to_9 == '' && to_10 == '') {

     var addPriceBtn = document.getElementById('addpricemodel');
     addPriceBtn.classList.add('red');
    }
    else {
        $("#right_side").fadeOut(400, function () {
            $(this).html('<div class="one_three_text"> <img src="./Tripwix_files/back.png" class="back-arrow" onclick="continue1Back()"> <p class="step_text">Step 2/3</p> <h2 class="heading_one_three">Prices Details</h2></div>        <div class="step_content prices_details"><div class="step2"> <div><input type="radio" id="pdr" name="price_details" value="Public display rates" checked> <label for="pdr">Public display rates<p>Rates include VAT                    & our commission</p></label></div> <div><input type="radio" id="nt" name="price_details"                value="Net rates"> <label for="nt">Net rates<p>Rates include our commission, but no VAT</p>            </label></div> <div> <input type="radio" id="pr" name="price_details" value="Payout rates"> <label                for="pr">Payout rates<p>What you want to be paid in total.</p></label></div><div> <input type="radio"                id="npr" name="price_details" value="Net payout rates"> <label for="npr">Net payout rates<p>What                    you want to be paid out before taxes.</p> </label></div>   </div>         <div class="button"> <button class="btn btn_main" id="continue2"                    onclick="continue3()">Continue</button> </div>        </div>').fadeIn(400);
        });
    }
}

function continue3() {
    var priceDetailsSelected = document.getElementsByName('price_details');
    for (i = 0; i < priceDetailsSelected.length; i++) {
        if (priceDetailsSelected[i].checked)
            priceDetails = priceDetailsSelected[i].value;
    }

    $("#right_side").fadeOut(400, function () {
        $(this).html('<div class="one_three_text"> <img src="./Tripwix_files/back.png" onclick="continue2Back()" class="back-arrow"> <p class="step_text">Step 3/3</p> <h2 class="heading_one_three">Availability</h2>    </div>    <div class="step_content availability"> <div class="step3List"><button class="btn_availability"            onclick="btn_availability_1()"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/></svg>Call me everytime</button>        <button class="btn_availability" onclick="btn_availability_2()"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-calendar-week" viewBox="0 0 16 16"> <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/> <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/> </svg>I have an iCal link</button> <button class="btn_availability" onclick="btn_availability_3()"> <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16"> <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/></svg>Check my website</button>        <div class="availability_input"> <label for="availability">Please give us</label> <input type="tel"                name="availability" id="availability" placeholder="Click options"> </div>  </div>      <div class="button bg-primary"> <button class="btn btn_main" id="continue2"                onclick="continue4()">Continue</button> </div>    </div>').fadeIn(400);
    });
}

let inputIsNumeric = false;

// Setting placeholder and type of input on button select in Availability Section
function btn_availability_1() {
    document.getElementById("availability").style.border = "";
    document.getElementById('availability').value = '';
    document.getElementById('availability').placeholder = "Phone Number";
    document.getElementById('availability').type = "tel";
    availabilityType = "Phone";

    inputIsNumeric = true;
    document.getElementById("availability").addEventListener("input", function (event) {
        if (inputIsNumeric) {
            event.target.value = event.target.value.replace(/[^0-9]+/g, '');
        }
    });

}
function btn_availability_2() {
    inputIsNumeric = false;
    document.getElementById('availability').value = '';
    document.getElementById("availability").style.border = "";
    document.getElementById('availability').placeholder = " ical link (has to be a link ending in .ics)";
    document.getElementById('availability').type = "url"
    availabilityType = "ical Link";


}
function btn_availability_3() {
    inputIsNumeric = false;
    document.getElementById('availability').value = '';
    document.getElementById("availability").style.border = "";
    document.getElementById('availability').placeholder = "Link to website";
    document.getElementById('availability').type = "url"
    availabilityType = "Website";


}



var placeholderInfo = '';
function continue4() {

    var placeholderTel = document.getElementById('availability').placeholder;

    if(placeholderTel === 'Click options'){
        document.getElementById("availability").style.border = "1px solid red";
    }else{
        document.getElementById("availability").style.border = "";
    }

    if(placeholderTel === 'Phone Number'){
        if (!/^\d+$/.test(document.getElementById("availability").value)) {
            document.getElementById("availability").style.border = "1px solid red";
          } else {
            document.getElementById("availability").style.border = "";

            availabilityLink = document.getElementById('availability').value;
            $("#right_side").fadeOut(400, function () {
                $(this).html('<div class="one_three_text">   <img src="./Tripwix_files/back.png" onclick="continue3Back()" class="back-arrow">         <p class="step_text">Step 3/3</p>            <h2 class="heading_one_three">Comment</h2>        </div>        <div class="step_content comment"> <div> <textarea name="" id="comment_textarea" cols="30" rows="10"                maxlength="250" placeholder="Anything we should know?" value="" onkeyup="counting()"></textarea>            <div id="the-count"> <span id="current">0</span> <span id="maximum">/ 250</span> </div>  </div>          <div class="button"> <button class="btn btn_main " id="continue2" onclick="SubForm()">Submit</button>            </div>        </div>').fadeIn(400);
            });
          }
    }

    if(placeholderTel === ' ical link (has to be a link ending in .ics)'){
        if (!/.+\.ics$/.test(document.getElementById("availability").value)) {
            document.getElementById("availability").style.border = "1px solid red";
          } else {
            document.getElementById("availability").style.border = "";

            availabilityLink = document.getElementById('availability').value;
            $("#right_side").fadeOut(400, function () {
                $(this).html('<div class="one_three_text">    <img src="./Tripwix_files/back.png" class="back-arrow" onclick="continue3Back()">        <p class="step_text">Step 3/3</p>            <h2 class="heading_one_three">Comment</h2>        </div>        <div class="step_content comment"> <div> <textarea name="" id="comment_textarea" cols="30" rows="10"                maxlength="250" placeholder="Anything we should know?" value="" onkeyup="counting()"></textarea>            <div id="the-count"> <span id="current">0</span> <span id="maximum">/ 250</span> </div>  </div>          <div class="button"> <button class="btn btn_main " id="continue2" onclick="SubForm()">Submit</button>            </div>        </div>').fadeIn(400);
            });
          }
    }

    if(placeholderTel === 'Link to website'){
        if (!/^(http:\/\/|https:\/\/|www\.).+/.test(document.getElementById("availability").value)) {
            document.getElementById("availability").style.border = "1px solid red";
          } else {
            document.getElementById("availability").style.border = "";

            availabilityLink = document.getElementById('availability').value;
            $("#right_side").fadeOut(400, function () {
                $(this).html('<div class="one_three_text">      <img src="./Tripwix_files/back.png" class="back-arrow" onclick="continue3Back()">      <p class="step_text">Step 3/3</p>            <h2 class="heading_one_three">Comment</h2>        </div>        <div class="step_content comment"> <div> <textarea name="" id="comment_textarea" cols="30" rows="10"                maxlength="250" placeholder="Anything we should know?" value="" onkeyup="counting()"></textarea>            <div id="the-count"> <span id="current">0</span> <span id="maximum">/ 250</span> </div>  </div>          <div class="button"> <button class="btn btn_main " id="continue2" onclick="SubForm()">Submit</button>            </div>        </div>').fadeIn(400);
            });
          }
    }

    placeholderInfo = placeholderTel;

}

function stepPrice() {

    $("#right_side").fadeOut(400, function () {
        $(this).html("<div class='one_three_text'> <p class='step_text' >Step 1/3</p> <h2 class='heading_one_three' >Please tell us</h2>        </div>        <div class='step_content '>            <form class='form'>                <div class='form-group'><label for='name'>Your Name</label><input type='text' class='form-control' id='name' placeholder='Your Name' value='" + namevalue + "'></div>                <div class='form-group grp_second'><label for='propertyName'>Property Name</label><input type='text' class='form-control' id='propertyName' placeholder='Property Name' value='" + propertyName + "'></div>            </form>            <div class='button'><button class='btn btn_main' id='continue1'                    onclick='continue1()'>Continue</button></div>        </div>").fadeIn(400);
    });
    
};

function continue1Back() {

    $("#right_side").fadeOut(400, function () {
        $(this).html('<div class="one_three_text"> <img src="./Tripwix_files/back.png" class="back-arrow""> <p class="step_text">Step 2/3</p> <h2 class="heading_one_three">Prices</h2></div>  <div class="step_content">          <div>  <div class="prices" id="prices"> </div>            <div class="addbtn"> <button class="add_price_btn btnopenprice" id="addpricemodel"  data-toggle="modal" data-target="#exampleModalCenter"><span>+ &nbsp&nbsp&nbsp</span> Add                    Price</button> </div>   </div>         <div class="button"> <button class="btn btn_main" id="continue2"                    onclick="continue2()">Continue</button> </div>        </div>').fadeIn(400);
    });

    var priceItem1 = '<div class="priceItem">            <div class="row">                <div class="date"> <span>' + from_1 + '</span> <span>-</span><span> ' + to_1 + ' </span>                    <p class="date_p" style="font-size: 12px; margin: 0; padding: 0; height: 16px;">' + price_1 +
    ' </p> <span class="date_season"                        style="color: rgba(0, 0, 0, 0.5); text-transform: uppercase; font-size: 12px; margin: 0; padding: 0;">'
    + season_1 + '</span>                </div>                <div class="icon"><i class="bi bi-calendar3"></i><p data-index="1" class="delete-price" onclick="deletePrice(event)">Delete</p></div>            </div>        </div>';

    var priceItem2 = '<div class="priceItem">            <div class="row">                <div class="date"> <span>' + from_2 + '</span> <span>-</span><span> ' + to_2 + ' </span>                    <p class="date_p" style="font-size: 12px; margin: 0; padding: 0; height: 16px;">' + price_2 +
    ' </p> <span class="date_season"                        style="color: rgba(0, 0, 0, 0.5); text-transform: uppercase; font-size: 12px; margin: 0; padding: 0;">'
    + season_2 + '</span>                </div>                <div class="icon"><i class="bi bi-calendar3"></i><p data-index="2" class="delete-price" onclick="deletePrice(event)">Delete</p></div>            </div>        </div>';

    var priceItem3 = '<div class="priceItem">            <div class="row">                <div class="date"> <span>' + from_3 + '</span> <span>-</span><span> ' + to_3 + ' </span>                    <p class="date_p" style="font-size: 12px; margin: 0; padding: 0; height: 16px;">' + price_3 +
    ' </p> <span class="date_season"                        style="color: rgba(0, 0, 0, 0.5); text-transform: uppercase; font-size: 12px; margin: 0; padding: 0;">'
    + season_3 + '</span>                </div>                <div class="icon"><i class="bi bi-calendar3"></i><p data-index="3" class="delete-price" onclick="deletePrice(event)">Delete</p></div>            </div>        </div>';

    var priceItem4 = '<div class="priceItem">            <div class="row">                <div class="date"> <span>' + from_4 + '</span> <span>-</span><span> ' + to_4 + ' </span>                    <p class="date_p" style="font-size: 12px; margin: 0; padding: 0; height: 16px;">' + price_4 +
    ' </p> <span class="date_season"                        style="color: rgba(0, 0, 0, 0.5); text-transform: uppercase; font-size: 12px; margin: 0; padding: 0;">'
    + season_4 + '</span>                </div>                <div class="icon"><i class="bi bi-calendar3"></i><p data-index="4" class="delete-price" onclick="deletePrice(event)">Delete</p></div>            </div>        </div>';

    var priceItem5 = '<div class="priceItem">            <div class="row">                <div class="date"> <span>' + from_5 + '</span> <span>-</span><span> ' + to_5 + ' </span>                    <p class="date_p" style="font-size: 12px; margin: 0; padding: 0; height: 16px;">' + price_5 +
    ' </p> <span class="date_season"                        style="color: rgba(0, 0, 0, 0.5); text-transform: uppercase; font-size: 12px; margin: 0; padding: 0;">'
    + season_5 + '</span>                </div>                <div class="icon"><i class="bi bi-calendar3"></i><p data-index="5" class="delete-price" onclick="deletePrice(event)">Delete</p></div>            </div>        </div>';

    var priceItem6 = '<div class="priceItem">            <div class="row">                <div class="date"> <span>' + from_6 + '</span> <span>-</span><span> ' + to_6 + ' </span>                    <p class="date_p" style="font-size: 12px; margin: 0; padding: 0; height: 16px;">' + price_6 +
    ' </p> <span class="date_season"                        style="color: rgba(0, 0, 0, 0.5); text-transform: uppercase; font-size: 12px; margin: 0; padding: 0;">'
    + season_6 + '</span>                </div>                <div class="icon"><i class="bi bi-calendar3"></i><p data-index="6" class="delete-price" onclick="deletePrice(event)">Delete</p></div>            </div>        </div>';

    var priceItem7 = '<div class="priceItem">            <div class="row">                <div class="date"> <span>' + from_7 + '</span> <span>-</span><span> ' + to_7 + ' </span>                    <p class="date_p" style="font-size: 12px; margin: 0; padding: 0; height: 16px;">' + price_8 +
    ' </p> <span class="date_season"                        style="color: rgba(0, 0, 0, 0.5); text-transform: uppercase; font-size: 12px; margin: 0; padding: 0;">'
    + season_7 + '</span>                </div>                <div class="icon"><i class="bi bi-calendar3"></i><p data-index="7" class="delete-price" onclick="deletePrice(event)">Delete</p></div>            </div>        </div>';

    var priceItem8 = '<div class="priceItem">            <div class="row">                <div class="date"> <span>' + from_8 + '</span> <span>-</span><span> ' + to_8 + ' </span>                    <p class="date_p" style="font-size: 12px; margin: 0; padding: 0; height: 16px;">' + price_8 +
    ' </p> <span class="date_season"                        style="color: rgba(0, 0, 0, 0.5); text-transform: uppercase; font-size: 12px; margin: 0; padding: 0;">'
    + season_8 + '</span>                </div>                <div class="icon"><i class="bi bi-calendar3"></i><p data-index="8" class="delete-price" onclick="deletePrice(event)">Delete</p></div>            </div>        </div>';

    var priceItem9 = '<div class="priceItem">            <div class="row">                <div class="date"> <span>' + from_9 + '</span> <span>-</span><span> ' + to_9 + ' </span>                    <p class="date_p" style="font-size: 12px; margin: 0; padding: 0; height: 16px;">' + price_9 +
    ' </p> <span class="date_season"                        style="color: rgba(0, 0, 0, 0.5); text-transform: uppercase; font-size: 12px; margin: 0; padding: 0;">'
    + season_9 + '</span>                </div>                <div class="icon"><i class="bi bi-calendar3"></i><p data-index="9" class="delete-price" onclick="deletePrice(event)">Delete</p></div>            </div>        </div>';

    var priceItem10 = '<div class="priceItem">            <div class="row">                <div class="date"> <span>' + from_10 + '</span> <span>-</span><span> ' + to_10 + ' </span>                    <p class="date_p" style="font-size: 12px; margin: 0; padding: 0; height: 16px;">' + price_10 +
    ' </p> <span class="date_season"                        style="color: rgba(0, 0, 0, 0.5); text-transform: uppercase; font-size: 12px; margin: 0; padding: 0;">'
    + season_10 + '</span>                </div>                <div class="icon"><i class="bi bi-calendar3"></i><p data-index="10" class="delete-price" onclick="deletePrice(event)">Delete</p></div>            </div>        </div>';


    setTimeout(function () {
        if(count_prices === 1){

            if(from_1 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem1);
                });
            }
        }
        if(count_prices === 2){

            if(from_1 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem1);
                });
            }
            if(from_2 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem2);
                });
            }
        }
        if(count_prices === 3){
            if(from_1 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem1);
                });
            }

            if(from_2 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem2);
                });
            }

            if(from_3 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem3);
                });
            }
      
        }
        if(count_prices === 4){
            if(from_1 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem1);
                });
            }
            if(from_2 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem2);
                });
            }
            if(from_3 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem3);
                });
            }
            if(from_4 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem4);
                });
            }

        }
        if(count_prices === 5){
            if(from_1 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem1);
                });
            }
            if(from_2 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem2);
                });
            }
            if(from_3 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem3);
                });
            }
            if(from_4 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem4);
                });
            }
            if(from_5 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem5);
                });
            }
        }
        if(count_prices === 6){
            if(from_1 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem1);
                });
            }
            if(from_2 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem2);
                });
            }
            if(from_3 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem3);
                });
            }
            if(from_4 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem4);
                });
            }
            if(from_5 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem5);
                });
            }
            if(from_6 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem6);
                });
            }
        }
        if(count_prices === 7){
            if(from_1 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem1);
                });
            }
            if(from_2 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem2);
                });
            }
            if(from_3 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem3);
                });
            }
            if(from_4 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem4);
                });
            }
            if(from_5 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem5);
                });
            }
            if(from_6 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem6);
                });
            }
            if(from_7 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem7);
                });
            }
        }
        if(count_prices === 8){
            if(from_1 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem1);
                });
            }
            if(from_2 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem2);
                });
            }
            if(from_3 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem3);
                });
            }
            if(from_4 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem4);
                });
            }
            if(from_5 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem5);
                });
            }
            if(from_6 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem6);
                });
            }
            if(from_7 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem7);
                });
            }
            if(from_8 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem8);
                });
            }
        }
        if(count_prices === 9){
            if(from_1 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem1);
                });
            }
            if(from_2 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem2);
                });
            }
            if(from_3 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem3);
                });
            }
            if(from_4 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem4);
                });
            }
            if(from_5 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem5);
                });
            }
            if(from_6 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem6);
                });
            }
            if(from_7 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem7);
                });
            }
            if(from_8 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem8);
                });
            }
            if(from_9 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem9);
                });
            }
        }
        if(count_prices === 10){
            if(from_1 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem1);
                });
            }
            if(from_2 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem2);
                });
            }
            if(from_3 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem3);
                });
            }
            if(from_4 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem4);
                });
            }
            if(from_5 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem5);
                });
            }
            if(from_6 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem6);
                });
            }
            if(from_7 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem7);
                });
            }
            if(from_8 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem8);
                });
            }
            if(from_9 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem9);
                });
            }
            if(from_10 != ''){
                pricesList = document.querySelector(".prices");
                pricesList.classList.add('active');

                $("#prices").fadeOut(100, function () {
                    $(this).append(priceItem10);
                });
            }
        }
      }, 1000);



    // from_1 = '';from_2 = '';from_3 = '';from_4 = '';from_5 = '';from_6 = '';from_7 = '';from_8 = '';from_9 = '';from_10 = '';
    // to_1 = '';to_2 = '';to_3 = '';to_4 = '';to_5 = '';to_6 = '';to_7 = '';to_8 = '';to_9 = '';to_10 = '';from1 = '';from2 = '';from3 = '';
    // from4 = '';from5 = '';from6 = '';from7 = '';from8 = '';from9 = '';from10 = '';to1 = '';to2 = '';to3 = '';to4 = '';to5 = '';
    // to6 = '';to7 = '';to8 = '';to9 = '';to10 = '';

    // $('input[name="datefilter1"]').data('daterangepicker').updateCalendars();

    // $("#right_side").fadeOut(400, function () {
    //     $(this).html('<div class="one_three_text"> <img src="./Tripwix_files/back.png" class="back-arrow""> <p class="step_text">Step 2/3</p> <h2 class="heading_one_three">Prices</h2></div>  <div class="step_content">          <div>  <div class="prices" id="prices"> </div>            <div class="addbtn"> <button class="add_price_btn btnopenprice" id="addpricemodel"  data-toggle="modal" data-target="#exampleModalCenter"><span>+ &nbsp&nbsp&nbsp</span> Add                    Price</button> </div>   </div>         <div class="button"> <button class="btn btn_main" id="continue2"                    onclick="continue2()">Continue</button> </div>        </div>').fadeIn(400);
    // });
 }

 function deletePrice(event){

    var clickedElement = event.target;
    var index = event.target.dataset.index;

        if(index == 1){
                icon = clickedElement.parentElement
                row = icon.parentElement;
                itemPrice = row.parentElement;
                
                var parent = itemPrice.parentElement;
                while (itemPrice.firstChild) {
                    itemPrice.removeChild(itemPrice.firstChild);
                  }
                  
                  parent.removeChild(itemPrice);

                from_1 = ''; to_1 = ''; season_1= ''; price_1 = ''; mn_1= '';
                from1= ''; to1= ''; 
                $('input[name="datefilter1"]').data('daterangepicker').updateCalendars();
              }

              if(index == 2){
                icon = clickedElement.parentElement
                row = icon.parentElement;
                itemPrice = row.parentElement;
                
                var parent = itemPrice.parentElement;
                while (itemPrice.firstChild) {
                    itemPrice.removeChild(itemPrice.firstChild);
                  }
                  
                  parent.removeChild(itemPrice);

                from_2 = ''; to_2 = ''; season_2= ''; price_2 = ''; mn_2= ''; 
                from2 = ''; to2 = '';
                $('input[name="datefilter1"]').data('daterangepicker').updateCalendars();
                console.log(from_2, to_2)


              }

              if(index == 3){
                icon = clickedElement.parentElement
                row = icon.parentElement;
                itemPrice = row.parentElement;
                
                var parent = itemPrice.parentElement;
                while (itemPrice.firstChild) {
                    itemPrice.removeChild(itemPrice.firstChild);
                  }
                  
                  parent.removeChild(itemPrice);

                from_3 = ''; to_3 = ''; season_3= ''; price_3 = ''; mn_3= '';
                from3 = ''; to3 = '';
                $('input[name="datefilter1"]').data('daterangepicker').updateCalendars();
                console.log(from_3, to_3)

               
              }

              if(index == 4){
                icon = clickedElement.parentElement
                row = icon.parentElement;
                itemPrice = row.parentElement;
                
                var parent = itemPrice.parentElement;
                while (itemPrice.firstChild) {
                    itemPrice.removeChild(itemPrice.firstChild);
                  }
                  
                  parent.removeChild(itemPrice);

                from_4 = ''; to_4 = ''; season_4= ''; price_4 = ''; mn_4= '';
                from4 = ''; to4 = '';
                $('input[name="datefilter1"]').data('daterangepicker').updateCalendars();
                console.log(from_4, to_4)
               
              }

              if(index == 5){
                icon = clickedElement.parentElement
                row = icon.parentElement;
                itemPrice = row.parentElement;
                
                var parent = itemPrice.parentElement;
                while (itemPrice.firstChild) {
                    itemPrice.removeChild(itemPrice.firstChild);
                  }
                  
                  parent.removeChild(itemPrice);

                from_5 = ''; to_5 = ''; season_5= ''; price_5 = ''; mn_5= '';
                from5 = ''; to5 = '';
                $('input[name="datefilter1"]').data('daterangepicker').updateCalendars();
               
              }

              if(index == 6){
                icon = clickedElement.parentElement
                row = icon.parentElement;
                itemPrice = row.parentElement;
                
                var parent = itemPrice.parentElement;
                while (itemPrice.firstChild) {
                    itemPrice.removeChild(itemPrice.firstChild);
                  }
                  
                  parent.removeChild(itemPrice);

                from_6 = ''; to_6 = ''; season_6= ''; price_6 = ''; mn_6= '';
                from6 = ''; to6 = '';
                $('input[name="datefilter1"]').data('daterangepicker').updateCalendars();

              }

              if(index == 7){
                icon = clickedElement.parentElement
                row = icon.parentElement;
                itemPrice = row.parentElement;
                
                var parent = itemPrice.parentElement;
                while (itemPrice.firstChild) {
                    itemPrice.removeChild(itemPrice.firstChild);
                  }
                  
                  parent.removeChild(itemPrice);

                from_7 = ''; to_7 = ''; season_7= ''; price_7 = ''; mn_7= '';
                from7 = ''; to7 = '';
                $('input[name="datefilter1"]').data('daterangepicker').updateCalendars();
                
              }

              if(index == 8){
                icon = clickedElement.parentElement
                row = icon.parentElement;
                itemPrice = row.parentElement;
                
                var parent = itemPrice.parentElement;
                while (itemPrice.firstChild) {
                    itemPrice.removeChild(itemPrice.firstChild);
                  }
                  
                  parent.removeChild(itemPrice);

                from_8 = ''; to_8 = ''; season_8= ''; price_8 = ''; mn_8= '';
                from8 = ''; to8 = '';
                $('input[name="datefilter1"]').data('daterangepicker').updateCalendars();
               
              }

              if(index == 9){
                icon = clickedElement.parentElement
                row = icon.parentElement;
                itemPrice = row.parentElement;
                
                var parent = itemPrice.parentElement;
                while (itemPrice.firstChild) {
                    itemPrice.removeChild(itemPrice.firstChild);
                  }
                  
                  parent.removeChild(itemPrice);

                from_9 = ''; to_9 = ''; season_9= ''; price_9 = ''; mn_9= '';
                from9 = ''; to9 = '';
                $('input[name="datefilter1"]').data('daterangepicker').updateCalendars();
               
              }

              if(index == 10){
                icon = clickedElement.parentElement
                row = icon.parentElement;
                itemPrice = row.parentElement;
                
                var parent = itemPrice.parentElement;
                while (itemPrice.firstChild) {
                    itemPrice.removeChild(itemPrice.firstChild);
                  }
                  
                  parent.removeChild(itemPrice);

                from_10 = ''; to_10 = ''; season_10= ''; price_10 = ''; mn_10= '';
                from10 = ''; to10 = '';
                $('input[name="datefilter1"]').data('daterangepicker').updateCalendars();
               
              }

              console.log(countDelete)

 }

 function refreshDatePicker() {
    let picker = $('input[name="datefilter1"]').data('daterangepicker');
    let options = picker.options;
    options.isInvalidDate = function (date) {
        return false;
    };
    $('input[name="datefilter1"]').daterangepicker(options);
}

 function continue2Back() {

        if(priceDetails == 'Public display rates'){
            $("#right_side").fadeOut(400, function () {
                $(this).html('<div class="one_three_text"> <img src="./Tripwix_files/back.png" class="back-arrow" onclick="continue1Back()"> <p class="step_text">Step 2/3</p> <h2 class="heading_one_three">Prices Details</h2></div>        <div class="step_content prices_details"><div class="step2"> <div><input type="radio" id="pdr" name="price_details" value="Public display rates" checked> <label for="pdr">Public display rates<p>Rates include VAT                    & our commission</p></label></div> <div><input type="radio" id="nt" name="price_details"                value="Net rates"> <label for="nt">Net rates<p>Rates include our commission, but no VAT</p>            </label></div> <div> <input type="radio" id="pr" name="price_details" value="Payout rates"> <label                for="pr">Payout rates<p>Whay you want to be paid in total.</p></label></div><div> <input type="radio"                id="npr" name="price_details" value="Net payout rates"> <label for="npr">Net payout rates<p>What                    you want to be paid out before taxes.</p> </label></div>   </div>         <div class="button"> <button class="btn btn_main" id="continue2"                    onclick="continue3()">Continue</button> </div>        </div>').fadeIn(400);
            });
        }
        if(priceDetails == 'Net rates'){
            $("#right_side").fadeOut(400, function () {
                $(this).html('<div class="one_three_text"> <img src="./Tripwix_files/back.png" class="back-arrow" onclick="continue1Back()"> <p class="step_text">Step 2/3</p> <h2 class="heading_one_three">Prices Details</h2></div>        <div class="step_content prices_details"><div class="step2"> <div><input type="radio" id="pdr" name="price_details" value="Public display rates"> <label for="pdr">Public display rates<p>Rates include VAT                    & our commission</p></label></div> <div><input type="radio" id="nt" name="price_details"                value="Net rates" checked> <label for="nt">Net rates<p>Rates include our commission, but no VAT</p>            </label></div> <div> <input type="radio" id="pr" name="price_details" value="Payout rates"> <label                for="pr">Payout rates<p>Whay you want to be paid in total.</p></label></div><div> <input type="radio"                id="npr" name="price_details" value="Net payout rates"> <label for="npr">Net payout rates<p>What                    you want to be paid out before taxes.</p> </label></div>   </div>         <div class="button"> <button class="btn btn_main" id="continue2"                    onclick="continue3()">Continue</button> </div>        </div>').fadeIn(400);
            });
        }
        if(priceDetails == 'Payout rates'){
            $("#right_side").fadeOut(400, function () {
                $(this).html('<div class="one_three_text"> <img src="./Tripwix_files/back.png" class="back-arrow" onclick="continue1Back()"> <p class="step_text">Step 2/3</p> <h2 class="heading_one_three">Prices Details</h2></div>        <div class="step_content prices_details"><div class="step2"> <div><input type="radio" id="pdr" name="price_details" value="Public display rates"> <label for="pdr">Public display rates<p>Rates include VAT                    & our commission</p></label></div> <div><input type="radio" id="nt" name="price_details"                value="Net rates" checked> <label for="nt">Net rates<p>Rates include our commission, but no VAT</p>            </label></div> <div> <input type="radio" id="pr" name="price_details" value="Payout rates" checked> <label                for="pr">Payout rates<p>Whay you want to be paid in total.</p></label></div><div> <input type="radio"                id="npr" name="price_details" value="Net payout rates"> <label for="npr">Net payout rates<p>What                    you want to be paid out before taxes.</p> </label></div>   </div>         <div class="button"> <button class="btn btn_main" id="continue2"                    onclick="continue3()">Continue</button> </div>        </div>').fadeIn(400);
            });
        }
        if(priceDetails == 'Net payout rates'){
            $("#right_side").fadeOut(400, function () {
                $(this).html('<div class="one_three_text"> <img src="./Tripwix_files/back.png" class="back-arrow" onclick="continue1Back()"> <p class="step_text">Step 2/3</p> <h2 class="heading_one_three">Prices Details</h2></div>        <div class="step_content prices_details"><div class="step2"> <div><input type="radio" id="pdr" name="price_details" value="Public display rates"> <label for="pdr">Public display rates<p>Rates include VAT                    & our commission</p></label></div> <div><input type="radio" id="nt" name="price_details"                value="Net rates" checked> <label for="nt">Net rates<p>Rates include our commission, but no VAT</p>            </label></div> <div> <input type="radio" id="pr" name="price_details" value="Payout rates"> <label                for="pr">Payout rates<p>Whay you want to be paid in total.</p></label></div><div> <input type="radio"                id="npr" name="price_details" value="Net payout rates" checked> <label for="npr">Net payout rates<p>What                    you want to be paid out before taxes.</p> </label></div>   </div>         <div class="button"> <button class="btn btn_main" id="continue2"                    onclick="continue3()">Continue</button> </div>        </div>').fadeIn(400);
            });
        }
}

function continue3Back() {
    console

    if(placeholderInfo === 'Click options'){
        $("#right_side").fadeOut(400, function () {
            $(this).html('<div class="one_three_text"> <img src="./Tripwix_files/back.png" onclick="continue2Back()" class="back-arrow"> <p class="step_text">Step 3/3</p> <h2 class="heading_one_three">Availability</h2>    </div>    <div class="step_content availability"> <div class="step3List"><button class="btn_availability"            onclick="btn_availability_1()"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/></svg>Call me everytime</button>        <button class="btn_availability" onclick="btn_availability_2()"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-calendar-week" viewBox="0 0 16 16"> <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/> <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/> </svg>I have an iCal link</button> <button class="btn_availability" onclick="btn_availability_3()"> <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16"> <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/></svg>Check my website</button>        <div class="availability_input"> <label for="availability">Please give us</label> <input type="tel"                name="availability" id="availability" placeholder="Click options"> </div>  </div>      <div class="button bg-primary"> <button class="btn btn_main" id="continue2"                onclick="continue4()">Continue</button> </div>    </div>').fadeIn(400);
        });
    }

    if(placeholderInfo === 'Phone Number'){
        availabilityType = "Phone";
        $("#right_side").fadeOut(400, function () {
            $(this).html('<div class="one_three_text"> <img src="./Tripwix_files/back.png" onclick="continue2Back()" class="back-arrow"> <p class="step_text">Step 3/3</p> <h2 class="heading_one_three">Availability</h2>    </div>    <div class="step_content availability"> <div class="step3List"><button class="btn_availability"            onclick="btn_availability_1()"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/></svg>Call me everytime</button>        <button class="btn_availability" onclick="btn_availability_2()"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-calendar-week" viewBox="0 0 16 16"> <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/> <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/> </svg>I have an iCal link</button> <button class="btn_availability" onclick="btn_availability_3()"> <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16"> <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/></svg>Check my website</button>        <div class="availability_input"> <label for="availability">Please give us</label> <input type="tel" value="'+ availabilityLink +'"  name="availability" id="availability"  placeholder=""></div>  </div>      <div class="button bg-primary"> <button class="btn btn_main" id="continue2"                onclick="continue4()">Continue</button> </div>    </div>').fadeIn(400);
        });
        setTimeout(() => {
            var availabilityTypeBorder = document.querySelectorAll('.btn_availability');
            availabilityTypeBorder[0].focus();
          }, 1000)

    }

    if(placeholderInfo === ' ical link (has to be a link ending in .ics)'){
        availabilityType = "ical Link";
        $("#right_side").fadeOut(400, function () {
            $(this).html('<div class="one_three_text"> <img src="./Tripwix_files/back.png" onclick="continue2Back()" class="back-arrow"> <p class="step_text">Step 3/3</p> <h2 class="heading_one_three">Availability</h2>    </div>    <div class="step_content availability"> <div class="step3List"><button class="btn_availability"            onclick="btn_availability_1()"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/></svg>Call me everytime</button>        <button class="btn_availability" onclick="btn_availability_2()"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-calendar-week" viewBox="0 0 16 16"> <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/> <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/> </svg>I have an iCal link</button> <button class="btn_availability" onclick="btn_availability_3()"> <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16"> <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/></svg>Check my website</button>        <div class="availability_input"> <label for="availability">Please give us</label> <input type="tel" value="'+ availabilityLink +'"    name="availability" id="availability"  placeholder=""> </div>  </div>      <div class="button bg-primary"> <button class="btn btn_main" id="continue2"                onclick="continue4()">Continue</button> </div>    </div>').fadeIn(400);
        });
        setTimeout(() => {
            var availabilityTypeBorder = document.querySelectorAll('.btn_availability');
            availabilityTypeBorder[1].focus();

          }, 1000)
    }

    if(placeholderInfo === 'Link to website'){
        availabilityType = "Website";
        $("#right_side").fadeOut(400, function () {
            $(this).html('<div class="one_three_text"> <img src="./Tripwix_files/back.png" onclick="continue2Back()" class="back-arrow"> <p class="step_text">Step 3/3</p> <h2 class="heading_one_three">Availability</h2>    </div>    <div class="step_content availability"> <div class="step3List"><button class="btn_availability"            onclick="btn_availability_1()"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/></svg>Call me everytime</button>        <button class="btn_availability" onclick="btn_availability_2()"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-calendar-week" viewBox="0 0 16 16"> <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/> <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/> </svg>I have an iCal link</button> <button class="btn_availability" onclick="btn_availability_3()"> <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-calendar" viewBox="0 0 16 16"> <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/></svg>Check my website</button>        <div class="availability_input"> <label for="availability">Please give us</label> <input type="tel" value="'+ availabilityLink +'"   name="availability" id="availability"  placeholder=""> </div>  </div>      <div class="button bg-primary"> <button class="btn btn_main" id="continue2"                onclick="continue4()">Continue</button> </div>    </div>').fadeIn(400);
        });
        setTimeout(() => {
            var availabilityTypeBorder = document.querySelectorAll('.btn_availability');
            availabilityTypeBorder[2].focus();
          }, 1000)
    }


}

// Form submitting function
function SubForm(){
    comment = document.getElementById('comment_textarea').value;
    document.getElementById('myForm1').value = new Date();
    document.getElementById('myForm2').value = namevalue;
    document.getElementById('myForm3').value = propertyName;
    document.getElementById('myForm4').value = availabilityType;
    document.getElementById('myForm5').value = availabilityLink;
    document.getElementById('myForm6').value = priceDetails;
    document.getElementById('myForm7').value = comment;
    document.getElementById('myForm8').value = price_1;
    document.getElementById('myForm9').value = from_1;
    document.getElementById('myForm10').value = to_1;
    document.getElementById('myForm11').value = mn_1;
    document.getElementById('myForm12').value = season_1;
    document.getElementById('myForm13').value = price_2;
    document.getElementById('myForm14').value = from_2;
    document.getElementById('myForm15').value = to_2;
    document.getElementById('myForm16').value = mn_2;
    document.getElementById('myForm17').value = season_2;
    document.getElementById('myForm18').value = price_3;
    document.getElementById('myForm19').value = from_3;
    document.getElementById('myForm20').value = to_3;
    document.getElementById('myForm21').value = mn_3;
    document.getElementById('myForm22').value = season_3;
    document.getElementById('myForm23').value = price_4;
    document.getElementById('myForm24').value = from_4;
    document.getElementById('myForm25').value = to_4;
    document.getElementById('myForm26').value = mn_4;
    document.getElementById('myForm27').value = season_4;
    document.getElementById('myForm28').value = price_5;
    document.getElementById('myForm29').value = from_5;
    document.getElementById('myForm30').value = to_5;
    document.getElementById('myForm31').value = mn_5;
    document.getElementById('myForm32').value = season_5;
    document.getElementById('myForm33').value = price_6;
    document.getElementById('myForm34').value = from_6;
    document.getElementById('myForm35').value = to_6;
    document.getElementById('myForm36').value = mn_6;
    document.getElementById('myForm37').value = season_6;
    document.getElementById('myForm38').value = price_7;
    document.getElementById('myForm39').value = from_7;
    document.getElementById('myForm40').value = to_7;
    document.getElementById('myForm41').value = mn_7;
    document.getElementById('myForm42').value = season_7;
    document.getElementById('myForm43').value = price_8;
    document.getElementById('myForm44').value = from_8;
    document.getElementById('myForm45').value = to_8;
    document.getElementById('myForm46').value = mn_8;
    document.getElementById('myForm47').value = season_8;
    document.getElementById('myForm48').value = price_9;
    document.getElementById('myForm49').value = from_9;
    document.getElementById('myForm50').value = to_9;
    document.getElementById('myForm51').value = mn_9;
    document.getElementById('myForm52').value = season_9;
    document.getElementById('myForm53').value = price_10;
    document.getElementById('myForm54').value = from_10;
    document.getElementById('myForm55').value = to_10;
    document.getElementById('myForm56').value = mn_10;
    document.getElementById('myForm57').value = season_10;


    $.ajax({
        url:"https://api.apispreadsheets.com/data/eLuy8Wt315SKTE4R/",
        type:"post",
        data:$("#myForm").serializeArray(),
        success: function(){
            submit();
        },
        error: function(){
            // const swalWithBootstrapButtons = Swal.mixin({
            //     customClass: {
            //         confirmButton: 'btn'
            //     },
            //     buttonsStyling: false
            // });
        
            // swalWithBootstrapButtons.fire({
            //     title: 'An error occured. Please try again.',
            //     icon: 'error',
            //     confirmButtonText: 'Ok',
            // });
        }
    });
}
function submit() {
    $("#right_side").fadeOut(400, function () {
        $(this).html('<div class="one_three_text">        <h2 class="heading_one_three thanks_heading">Thank You!</h2>    </div>    <div class="step_content thanks"><div> <a href="#" target="_blank"><div class="finishImage">photo will come here and will be clickable</div></a>        <a href="#" target="_blank"><div class="finishImage"></div></a> <a href="#" target="_blank"            class="mobile_thanks_img"><div class="finishImage"></div></a> </div>   </div>').fadeIn(400);
    });
    // const swalWithBootstrapButtons = Swal.mixin({
    //     customClass: {
    //         confirmButton: 'btn'
    //     },
    //     buttonsStyling: false
    // })

    // swalWithBootstrapButtons.fire({
    //     title: 'Details Submitted',
    //     icon: 'success',
    //     confirmButtonText: 'Ok',
    // })
}
// Icon x close calendar
var input1 = document.getElementById('fromDate');
var input2 = document.getElementById('toDate');

input1.addEventListener('click', function() {
    var daterange = document.querySelectorAll('.daterangepicker');
    daterange[2].style.display = 'block';

    for(date of daterange){
        if(date.style.display === "block"){
            var closeX = daterange[2].childNodes[2].childNodes[0];
            closeX.addEventListener('click', function(){
                daterange[2].style.display = 'none';
            });
        }
    }

});

input2.addEventListener('click', function() {
    var daterange = document.querySelectorAll('.daterangepicker');
    daterange[3].style.display = 'block';

    for(date of daterange){
        if(date.style.display === "block"){
            var closeX = date.childNodes[2].childNodes[0];
            closeX.addEventListener('click', function(){
                date.style.display = 'none';
            });
        }
    }

});



function convertDate(){

    if(from_1 != '' && to_1 != ''){
        from1 = convertDateFormat(from_1);
        to1 = convertDateFormat(to_1);
    }
    if(from_2 != '' && to_2 != ''){
        from2 = convertDateFormat(from_2);
        to2 = convertDateFormat(to_2);
    }
    if(from_3 != '' && to_3 != ''){
        from3 = convertDateFormat(from_3);
        to3 = convertDateFormat(to_3);
    }
    if(from_4 != '' && to_4 != ''){
        from4 = convertDateFormat(from_4);
        to4 = convertDateFormat(to_4);
    }
    if(from_5 != '' && to_5 != ''){
        from5 = convertDateFormat(from_5);
        to5 = convertDateFormat(to_5);
    }
    if(from_6 != '' && to_6 != ''){
        from6 = convertDateFormat(from_6);
        to6 = convertDateFormat(to_6);
    }
    if(from_7 != '' && to_7 != ''){
        from7 = convertDateFormat(from_7);
        to7 = convertDateFormat(to_7);
    }
    if(from_8 != '' && to_8 != ''){
        from8 = convertDateFormat(from_8);
        to8 = convertDateFormat(to_8);
    }
    if(from_9 != '' && to_9 != ''){
        from9 = convertDateFormat(from_9);
        to9 = convertDateFormat(to_9);
    }
    if(from_10 != '' && to_10 != ''){
        from10 = convertDateFormat(from_10);
        to10 = convertDateFormat(to_10);
    }
}

function convertDateFormat(dateString) {
    const date = new Date(dateString.split("/").reverse().join("-"));
    return date.toISOString().split("T")[0];
  }

// Date Picker
$(function () {

    $('input[name="datefilter1"]').daterangepicker({
        autoApply: true,
        autoUpdateInput: false,
        minDate: moment().startOf('day'),
        isInvalidDate: function (date) {
            var previousDay1 = moment(from1).subtract(1, 'days').format('YYYY-MM-DD');
            var previousDay2 = moment(from2).subtract(1, 'days').format('YYYY-MM-DD');
            var previousDay3 = moment(from3).subtract(1, 'days').format('YYYY-MM-DD');
            var previousDay4 = moment(from4).subtract(1, 'days').format('YYYY-MM-DD');
            var previousDay5 = moment(from5).subtract(1, 'days').format('YYYY-MM-DD');
            var previousDay6 = moment(from6).subtract(1, 'days').format('YYYY-MM-DD');
            var previousDay7 = moment(from7).subtract(1, 'days').format('YYYY-MM-DD');
            var previousDay8 = moment(from8).subtract(1, 'days').format('YYYY-MM-DD');
            var previousDay9 = moment(from9).subtract(1, 'days').format('YYYY-MM-DD');
            var previousDay10 = moment(from10).subtract(1, 'days').format('YYYY-MM-DD');


            const invalidRanges = [
                { start: new Date(previousDay1), end: new Date(to1) },
                { start: new Date(previousDay2), end: new Date(to2) },
                { start: new Date(previousDay3), end: new Date(to3) },
                { start: new Date(previousDay4), end: new Date(to4) },
                { start: new Date(previousDay5), end: new Date(to5) },
                { start: new Date(previousDay6), end: new Date(to6) },
                { start: new Date(previousDay7), end: new Date(to7) },
                { start: new Date(previousDay8), end: new Date(to8) },
                { start: new Date(previousDay9), end: new Date(to9) },
                { start: new Date(previousDay10), end: new Date(to10) },
            ];
    
            return invalidRanges.some(
                // (range) => date >= range.start && date <= range.end
                (range) => moment(date).isSame(range.start) || (moment(date).isAfter(range.start) && moment(date).isBefore(range.end))
            );
        },
   
        locale: {
            cancelLabel: 'Clear'
        },

    });

    $('input[name="datefilter1"]').on('apply.daterangepicker', function (ev, picker) {
        
        $(this).val(picker.startDate.format('DD/MM/YYYY'));
        $('input[name="datefilter2"]').val(picker.endDate.format('DD/MM/YYYY'));
    });

    $('input[name="datefilter1"]').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
        $('input[name="datefilter2"]').val('');
    });

});
$(function () {


    $('input[name="datefilter2"]').daterangepicker({
        autoApply: true,
        autoUpdateInput: false,
        minDate: moment().startOf('day'),
        isInvalidDate: function (date) {
            var previousDay1 = moment(from1).subtract(1, 'days').format('YYYY-MM-DD');
            var previousDay2 = moment(from2).subtract(1, 'days').format('YYYY-MM-DD');
            var previousDay3 = moment(from3).subtract(1, 'days').format('YYYY-MM-DD');
            var previousDay4 = moment(from4).subtract(1, 'days').format('YYYY-MM-DD');
            var previousDay5 = moment(from5).subtract(1, 'days').format('YYYY-MM-DD');
            var previousDay6 = moment(from6).subtract(1, 'days').format('YYYY-MM-DD');
            var previousDay7 = moment(from7).subtract(1, 'days').format('YYYY-MM-DD');
            var previousDay8 = moment(from8).subtract(1, 'days').format('YYYY-MM-DD');
            var previousDay9 = moment(from9).subtract(1, 'days').format('YYYY-MM-DD');
            var previousDay10 = moment(from10).subtract(1, 'days').format('YYYY-MM-DD');


            const invalidRanges = [
                { start: new Date(previousDay1), end: new Date(to1) },
                { start: new Date(previousDay2), end: new Date(to2) },
                { start: new Date(previousDay3), end: new Date(to3) },
                { start: new Date(previousDay4), end: new Date(to4) },
                { start: new Date(previousDay5), end: new Date(to5) },
                { start: new Date(previousDay6), end: new Date(to6) },
                { start: new Date(previousDay7), end: new Date(to7) },
                { start: new Date(previousDay8), end: new Date(to8) },
                { start: new Date(previousDay9), end: new Date(to9) },
                { start: new Date(previousDay10), end: new Date(to10) },
            ];
    
            return invalidRanges.some(
                // (range) => date >= range.start && date <= range.end
                (range) => moment(date).isSame(range.start) || (moment(date).isAfter(range.start) && moment(date).isBefore(range.end))
            );
        },
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('input[name="datefilter2"]').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.endDate.format('DD/MM/YYYY'));
        $('input[name="datefilter1"]').val(picker.startDate.format('DD/MM/YYYY'));
    });

    $('input[name="datefilter2"]').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
        $('input[name="datefilter1"]').val('');
    });

});
// End Date Picker


// Count Character textarea comment 
function counting() {

    var characterCount = document.getElementById('comment_textarea').value.length;
        current = $('#current'),
        maximum = $('#maximum'),
        theCount = $('#the-count');

    current.text(characterCount);
};
