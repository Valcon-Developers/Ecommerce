function togglePassword() {
    var passInput = document.getElementById("pass");
    if (passInput.type === "password") {
        passInput.type = "text";
    } else {
        passInput.type = "password";
    }
}
// confirmation massage for button 
$('.confirm').click(function(){
    return confirm('Are You Sure');
})

$('.cat h3').click(function(){
    $(this).next('.full-view').fadeToggle(600);
})

$('.Option span').click(function(){
    $(this).addClass('active').siblings('span').removeClass('active');
    if($(this).data('view')==='full'){
        $('.cat .full-view').fadeIn(200);
    }else{
        $('.cat .full-view').fadeOut(200);
    } 
})

///////////////////////////////////////

function getSearch(arrange="table-row") {
    let trbox = document.getElementsByClassName("trbox");
    let tditem = document.getElementsByClassName("tditem");
    let mainSection = document.getElementById("mainSection");
    let hiddenSection = document.getElementById("hiddenSection");
    let addbtn = document.getElementById("addbtn");
    let search = document.getElementById("search").value.toUpperCase();
    let found = false;

    for (let i = 0; i < tditem.length; i++) {
        if (tditem[i].innerHTML.toUpperCase().indexOf(search) >= 0) {
            trbox[i].style.display = arrange;
            found = true;
        } else {
            trbox[i].style.display = "none";
        }
    }

    if (!found) {
        mainSection.style.display = "none";
        hiddenSection.style.display = "block";
        hiddenSection.innerHTML = "<div class='text-center m-5 h4 text-danger'>No match found</div>";
        addbtn.style.display = "none";
    } else {
        mainSection.style.display = "block";
        hiddenSection.style.display = "none";
        addbtn.style.display = "inline-block";        

    }
}

////////////////////////////////////
function Archived($display){
    $Archived=document.getElementById('Archived');
    $Archived.style.display=$display

}



function printPart(name) {
    let originalName=document.title;
    let tempName=name;
    document.title=tempName;
    var elements = document.getElementsByClassName('pillControles');

    for (var i = 0; i < elements.length; i++) {
    elements[i].style.display = 'none';
    }

    window.print();
    document.title=originalName;
    for (var i = 0; i < elements.length; i++) {
    elements[i].style.display = 'block';
    }
}



