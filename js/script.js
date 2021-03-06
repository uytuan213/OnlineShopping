function signUpValidate(){
	let form = document.getElementById("signUpForm");
	let username = document.getElementById("txtUsername");
	let pwd = document.getElementById("txtPassword");
	let confirmPwd = document.getElementById("txtConfirmPassword");
	let fName = document.getElementById("txtFirstName");
	let lName = document.getElementById("txtLastName");
	let dob = document.getElementById("txtDOB");
	let address = document.getElementById("txtAddress");
	let city = document.getElementById("txtCity");
	//let province = document.getElementById("txtProvince").value;
	let postalCode = document.getElementById("txtPostalCode");
	let email = document.getElementById("txtEmail");
	let check = true;

	let pcRegex = new RegExp(/^[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ]( )?\d[ABCEGHJKLMNPRSTVWXYZ]\d$/);
	let emailRegex = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);

	let message = "";
	if (username.value == "") {
		message += "Username is required<br>";
	}	

	if (pwd.value == "") {
		message += "Password is required<br>";
	}

	if(pwd.value != confirmPwd.value){
		// displayError(confirmPwd);
		message += "Confirm password doesn't match<br>";
		check = false;
	}
	if (fName.value == "") {
		message += "First name cannot be blank<br>";
		check = false;
	}
	if (lName.value == "") {
		message += "Last name cannot be blank<br>";
		check = false;
	}
	let dob_value = new Date(dob.value);
	let now = Date.now();
	if (dob_value > now) {
		// displayError(dob);
		message += "Date of birth cannot be in future<br>";
		check = false;
	}
	if (!pcRegex.test(postalCode.value)) {
		// displayError(postalCode);
		message += "Postal code is invalid<br>";
		check = false;
	}
	if (!emailRegex.test(email.value)) {
		// displayError(email);
		message += "Email is invalid<br>";
		check = false;
	}
	if(check){
		form.submit();
	}
	else{
		let error_message = document.getElementById("message");
		message = "<i>" + message + "</i>";
		error_message.innerHTML = message;
		// error_message.style.border = "1px solid red";
		// error_message.parentElement.display = "initial";
		// alert(document.getElementById("message").innerHTML);
	}
}

function logInValidate(){
	let form = document.getElementById("logInForm");
	let username = document.getElementById("txtUsername");
	let pwd = document.getElementById("txtPassword");

	let message = "";
	if (username.value == "") {
		message += "Username is required<br>";
	}
	if (pwd.value == "") {
		message += "Password is required<br>";
	}
	if(message == ""){
		form.submit();
	}
	else{
		let error_message = document.getElementById("message");
		message = "<i>" + message + "</i>";
		error_message.innerHTML = message;
	}
}
// Function to validate user change to update to db
function changeInfoValidate(){
	let inputs = document.getElementsByTagName("input");
	let messsage = "";
	for (var i = 0; i < inputs.length; i++) {
		if (inputs[i].value == "") {
			message = "All input must be filled";
			break;
		}
	}
	if (message == "") {
		document.getElementById("infoForm").submit();
	}
	else{
		let error_message = document.getElementById("message");
		message = "<i>" + message + "</i>";
		error_message.innerHTML = message;
	}
}

// Function to validate user's new password
function changePasswordValidate(){
	let inputs = document.getElementsByTagName("input");
	let message = "";
	//var to check if there is any empty input field
	let checkEmpty = true;
	for (var i = 0; i < inputs.length; i++) {
		if (inputs[i].value == "") {
			message = "All input must be filled";
			checkEmpty = false;
			break;
		}
	}
	if (checkEmpty) {
		let pwd = document.getElementById("txtNewPassword");
		let confirmPwd = document.getElementById("txtConfirmPassword");
		if (pwd.value != confirmPwd.value) {
			message = "New password and confirm password are not matched";
		}
	}
	if (message == "") {
		document.getElementById("changePasswordForm").submit();
	}
	else{
		let error_message = document.getElementById("message");
		error_message.innerHTML = "<i>" + message + "</i>";
	}

}