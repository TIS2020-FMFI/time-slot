let link = document.createElement("a");
// CONVERT JASON DATA TO EXCEL
// JSONToCSVConvertor(data,"TITLE",true);
function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
    //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;

    var CSV = '';
    //Set Report title in first row or line

    //CSV += ReportTitle + '\r\n\n';
    CSV += 'id,ramp number,firm name,truck driver 1,truck driver 2,truck evc,destination,cargo,start time slot time,end time slot time,state' + '\r\n';
    //This condition will generate the Label/Header
    // if (ShowLabel) {
    //     var row = "";
    //
    //     //This loop will extract the label from 1st index of on array
    //     for (var index in arrData[0]) {
    //
    //         //Now convert each value to string and comma-seprated
    //         row += index + ',';
    //     }
    //
    //     row = row.slice(0, -1);
    //
    //     //append Label row with line break
    //     if (row === '0'){
    //         row = 'id';
    //     }
    //     //CSV += row + '\r\n';
    //     //console.log(row);
    // }

    //1st loop is to extract each row
    for (var i = 0; i < arrData.length; i++) {
        var row = "";

        //2nd loop will extract each column and convert it in string comma-seprated
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
        }

        row.slice(0, row.length - 1);

        //add a line break after each row
        CSV += row + '\r\n';
    }

    if (CSV === '') {
        create_exception("Invalid data",10,'danger');
        return;
    }
    else{
        create_exception("Data was succafully obtained and prepared ",3,'success')
    }

    //Generate a file name
    var fileName = "Statistics_";
    //this will remove the blank-spaces from the title and replace it with an underscore
    fileName += ReportTitle.replace(/ /g,"_");

    //Initialize file format you want csv or xls
    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);

    // Now the little tricky part.
    // you can use either>> window.open(uri);
    // but this will not work in some browsers
    // or you will not get the correct file extension

    //this trick will generate a temp <a /> tag

    link.href = uri;

    //set the visibility hidden so it will not effect on your web-layout
    link.style = "visibility:hidden";
    link.download = fileName + ".csv";

    //this part will append the anchor tag and remove it after automatic click

}

function export_all_statistics(){
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    //setTimeout(generate_HTML,250); // nutne cakanie koli spracovaniu dat ktor boli ziskane ajaxom
}
