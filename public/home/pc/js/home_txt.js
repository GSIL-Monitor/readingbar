  function show(){
    var box = document.getElementById("box");
    var text = box.innerHTML;
    var newBox = document.createElement("div");
    var btn = document.createElement("a");
    newBox.innerHTML = text.substring(0,150);
    btn.innerHTML = text.length > 150 ? "...更多" : "";
    btn.href = "###";
    btn.onclick = function(){
    if (btn.innerHTML == "...更多"){
    btn.innerHTML = "收起";
    newBox.innerHTML = text;
    }else{
    btn.innerHTML = "...更多";
    newBox.innerHTML = text.substring(0,150);
    }
    }
    box.innerHTML = "";
    box.appendChild(newBox);
    box.appendChild(btn);
  }
  show();
  function show2(){
    var box = document.getElementById("box2");
    var text = box.innerHTML;
    var newBox = document.createElement("div");
    var btn = document.createElement("a");
    newBox.innerHTML = text.substring(0,145);
    btn.innerHTML = text.length > 145 ? "...更多" : "";
    btn.href = "###";
    btn.onclick = function(){
    if (btn.innerHTML == "...更多"){
    btn.innerHTML = "收起";
    newBox.innerHTML = text;
    }else{
    btn.innerHTML = "...更多";
    newBox.innerHTML = text.substring(0,145);
    }
    }
    box.innerHTML = "";
    box.appendChild(newBox);
    box.appendChild(btn);
  }
  show2();
function show3(){
    var box = document.getElementById("box3");
    var text = box.innerHTML;
    var newBox = document.createElement("div");
    var btn = document.createElement("a");
    newBox.innerHTML = text.substring(0,145);
    btn.innerHTML = text.length > 145 ? "...更多" : "";
    btn.href = "###";
    btn.onclick = function(){
    if (btn.innerHTML == "...更多"){
    btn.innerHTML = "收起";
    newBox.innerHTML = text;
    }else{
    btn.innerHTML = "...更多";
    newBox.innerHTML = text.substring(0,145);
    }
    }
    box.innerHTML = "";
    box.appendChild(newBox);
    box.appendChild(btn);
  }
  show3();
function show4(){
    var box = document.getElementById("box4");
    var text = box.innerHTML;
    var newBox = document.createElement("div");
    var btn = document.createElement("a");
    newBox.innerHTML = text.substring(0,147);
    btn.innerHTML = text.length > 147 ? "...更多" : "";
    btn.href = "###";
    btn.onclick = function(){
    if (btn.innerHTML == "...更多"){
    btn.innerHTML = "收起";
    newBox.innerHTML = text;
    }else{
    btn.innerHTML = "...更多";
    newBox.innerHTML = text.substring(0,147);
    }
    }
    box.innerHTML = "";
    box.appendChild(newBox);
    box.appendChild(btn);
  }
  show4();