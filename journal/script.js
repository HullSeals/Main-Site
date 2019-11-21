var openFile = function(event) {
    var input = event.target;

    var reader = new FileReader();
    reader.onload = function(){
        var text = reader.result;
        var node = document.getElementById('output');
        //node.innerText = text;
        var lines = reader.result.split("\n");
        let cleaned="";
        lines.forEach(function(line) {
            if(line.length !== 0)
            {
                cleaned += line+",";
            }
        });
        let cleanedJson = '[' + cleaned.slice(0, -1) + ']';
//        node.innerText = cleaned;
        var jsonObj = JSON.parse(cleanedJson);
        var searchQuery = document.getElementById("myText").value;
        var lastObject;
        var synts = 0;
        let iron = 0;
        let nickel = 0;
        jsonObj.forEach(function(data, index) {
            if(data.event.toLowerCase() === searchQuery.toLowerCase())
            {
                lastObject = data;
                console.log(data.Raw);
            }
            if (data.event === "Materials") {
                data.Raw.forEach(function(material,i)
                {
                    if(material.Name==="iron")
                    {
                        iron = material.Count;
                    }
                    if(material.Name==="nickel")
                    {
                        nickel = material.Count;
                    }
                });

            }
        });
        //Life support calculation
        let ironForLifeSupport = Math.floor(iron/2);
        if(ironForLifeSupport<nickel)
        {
            console.log("You can make: "+ironForLifeSupport+" life support things.")
        }
        if(ironForLifeSupport > nickel)
        {
            console.log("You can make: "+nickel+" life support things.")
        }
        //node.innerText = lastObject.StarSystem;

    };
    reader.readAsText(input.files[0]);

};