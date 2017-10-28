    function configureDropDownLists(college1,course) {
        var cea = ['Architecture', 'Civil Engineering', 'Electrical Engineering', 'Electronics Engineering' , 'Mechanical Engineering'];
        var citc = ['Computer Engineering', 'Information Technology', 'Technology Communication and Management'];
        var cas = ['Food and Science Technology', 'David', 'Sarah'];

                switch (college1.value) {
        case 'CEA':
            course.options.length = 0;
            for (i = 0; i < cea.length; i++) {
                createOption(course, cea[i], cea[i]);
            }
            break;
        case 'CITC':
            course.options.length = 0; 
        for (i = 0; i < citc.length; i++) {
            createOption(course, citc[i], citc[i]);
            }
            break;
        case 'CAS':
            course.options.length = 0;
            for (i = 0; i < cas.length; i++) {
                createOption(course, cas[i], cas[i]);
            }
            break;
            default:
                course.options.length = 0;
            break;
    }

}

    function createOption(college, text, value) {
        var opt = document.createElement('option');
        opt.value = value;
        opt.text = text;
        college.options.add(opt);}
    function checkPass(){
    var pass1 = document.getElementById('password');
    var pass2 = document.getElementById('cpassword');
    var message = document.getElementById('confirmMessage');
    var goodColor = "#66cc66";
    var badColor = "#ff6666";

        if(pass1.value == pass2.value)
        {
            pass2.style.backgroundColor = goodColor;
            message.style.color = goodColor;
            message.innerHTML = "Passwords Match!"
        }
        else
        {  
            pass2.style.backgroundColor = badColor;
            message.style.color = badColor;
            message.innerHTML = "Passwords Do Not Match!"
        }
    }