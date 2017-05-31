function generateApiKey(elemId)
        {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz01234567890123456789";

            for( var i=0; i < 20; i++ ) {
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            }

            document.getElementById(elemId).value = text;
        }