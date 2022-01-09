class FileUpload {

    url;

    constructor(url) {
        this.url = url;
    }

    upload(target) {
        var fd = new FormData();
        var files = target[0].files;

        if (files.length > 0) {
            for (let i = 0; i < files.length; i++) {
                fd.append("files[]", files[i]);
            }

            $.ajax({
                url: this.url,
                type: "post",
                data: fd,
                contentType: false,
                processData: false,
                success:(response)=>{
                    console.log(response);
                }
            })
        }else{
            alert("Žádný soubor");
        }
    }

}