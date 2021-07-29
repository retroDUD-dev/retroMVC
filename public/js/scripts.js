function clear_div(str){
    document.getElementById(str).innerHTML = "";
}

function isOverflowing(){
    var rows = document.getElementById("output").getAttribute("rows")*1 + 1;

    if(document.getElementById("output").clientHeight < document.getElementById("output").scrollHeight){
        document.getElementById("output").setAttribute("rows", rows);
        setTimeout(isOverflowing, 50);
    }
}

function typing(){
    if(skip){
        clear_div("output");
        document.getElementById("output").innerHTML = txt;
        isOverflowing();
        if(!!document.getElementById("skip")){
            document.getElementById("skip").style.display = "none";
        }
        if(!!document.getElementById("hidden")){
            document.getElementById("hidden").style.display = "flex";
        }
        return;
    }
    if(i< txt.length){
        document.getElementById("output").innerHTML += txt.charAt(i);
        i++;
        isOverflowing();
        setTimeout(typing, 40);
    }else{
        if(!!document.getElementById("hidden")){
            document.getElementById("hidden").style.display = "flex";
        }
        if(!!document.getElementById("skip")){
            document.getElementById("skip").style.display = "none";
        }
    }
}

function selectChar(rowCount){
    document.getElementById('check' + rowCount).checked = true;
    document.getElementById('check' + rowCount).value = rowCount;
}

function pageSelector(step){
    clear_div("phpContainer")
    x = document.getElementById("phpContainer");
    switch(step){
        case 0:
            x.innerHTML = '<?php include_once $_SERVER[\'DOCUMENT_ROOT\']."/./php/CreateNewCharacter.php"; ?>';
            break;
        case 1:
            x.innerHTML = '<?php include_once $_SERVER[\'DOCUMENT_ROOT\']."/./php/SetAttacks.php"; ?>';
            break;
        case 2:
            x.innerHTML = '<?php include_once $_SERVER[\'DOCUMENT_ROOT\']."/./php/SetEquipment.php"; ?>';
            break;
        case 3:
            x.innerHTML = '<?php include_once $_SERVER[\'DOCUMENT_ROOT\']."/./php/SetFeatures.php"; ?>';
            break;
        case 4:
            x.innerHTML = '<?php include_once $_SERVER[\'DOCUMENT_ROOT\']."/./php/Summary.php"; ?>';
            break;
        default:
            x.innerHTML = '<= "./php/intro.php"; ?>';
            break;
    }
}

function addAttack(){
    i = 0;
    clear_div("output");
    if(!attack){
        attack = 0;
    }
    attack *= 1;
    attack += 1;
    document.getElementById("attack").innerHTML = "Attacks: " + attack;
    txt = "Attack added!";
    typing();
}

function addItem(){
    i = 0;
    clear_div("output");
    if(!item){
        item = 0;
    }
    item *= 1;
    item += 1;
    document.getElementById("item").innerHTML = "Items: " + item;
    txt = "Item added!";
    typing();
}

function addFeature(){
    i = 0;
    clear_div("output");
    if(!feature){
        feature = 0;
    }
    feature *= 1;
    feature += 1;
    document.getElementById("feature").innerHTML = "Features: " + feature;
    txt = "Feature added!";
    typing();
}

function lol(){
    document.getElementById("lol").innerHTML = "LOL";
}