// property.blade.php

function copyToClipboard(text) {
    var inputc = document.body.appendChild(document.createElement("input"));
        
    // Tambahkan kalimat promosi dan link saat disalin ke clipboard
    var promotionText = "Cek properti menarik di Domus Mea: " + document.title + " - " + window.location.href;
        
    inputc.value = promotionText;
    inputc.select();
    document.execCommand('copy');
    inputc.parentNode.removeChild(inputc);
    
    alert("Link berhasil dicopy");
    }
    