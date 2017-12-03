var at = document.getElementById('at');
var et = document.getElementById('et');
var dlt = document.getElementById('dlt');

function showAddSection() {
    if (at.style.display !== 'none') {
        at.style.display = 'none';
    }
    else {
        if(et.style.display !== 'none' || dlt.style.display !== 'none'){
            at.style.display = 'block';
            et.style.display = 'none';
            dlt.style.display = 'none';
        }
        else {
            at.style.display = 'block';
        }
    }
}

function showEditSection() {
    if (et.style.display !== 'none') {
        et.style.display = 'none';
    }
    else {
        if(at.style.display !== 'none' || dlt.style.display !== 'none'){
            et.style.display = 'block';
            at.style.display = 'none';
            dlt.style.display = 'none';
        }
        else {
            et.style.display = 'block';
        }
    }
}

function showDLSection() {
    if (dlt.style.display !== 'none') {
        dlt.style.display = 'none';
    }
    else {
        if(at.style.display !== 'none' || et.style.display !== 'none'){
            dlt.style.display = 'block';
            at.style.display = 'none';
            et.style.display = 'none';
        }
        else {
            dlt.style.display = 'block';
        }
    }
}