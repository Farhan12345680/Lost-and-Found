const param = new URLSearchParams(window.location.search);
let page  = param.get('page')  ?? '1';
let limit = param.get('limit') ?? '12';
let para    = param.get('id')    ?? '';







let built='' ;


console.log(page + " "+limit+ " "+para);

(function(){

    if(!para){
    fetch('http://localhost:80/dashboard/PDO/fetchFound/fetch.php',{
        method:"POST",
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            array : ["%%"]
        })
    })
    .then(res =>{
        const ui= res.json();
        
        return ui;
    })
    .then(
        res =>     display(res));

        return;
    }
    ui= para.split(' ');

    ui.forEach(a1 => {
        const a = document.createElement("a");
        built += a1+" ";
        a.textContent = a1;
        a.href = window.location.origin + "/html/foundItems.html?id=" + built;
        a.classList.add("crumb");
        breadcrumb.appendChild(a);
    });
    let io=[];
    for(let i =0 ;i<ui.length; i+=1){
        io[i]="%"+ui[i]+"%";
    }

    fetch('http://localhost:80/dashboard/PDO/fetchFound/fetch.php',{
        method:"POST",
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            array : io
        })
    })
    .then(res =>{
        const ui= res.json();
        console.log(ui);
        
        return ui;
    })
    .then(
        res =>{
            display(res);

        });


})();



console.log(page+" "+limit);

searchInput.addEventListener(
    "keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault(); 

            let a= document.createElement('a');
            let string1 = searchInput.value.trim();
            searchInput.value='';
            para =para??''
            window.location.href='?id='+para+encodeURIComponent(" "+string1);

        }
    })




