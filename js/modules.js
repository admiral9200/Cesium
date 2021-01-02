//fetch user profile name
export const getProfile = () => {
	let xhr = new XMLHttpRequest();
	xhr.open('GET', '/php/functions.php?user', true);
	xhr.onload = function(){
		if (this.status == 200) {
			let profile = JSON.parse(this.responseText);
			document.getElementById('dropdownMenuLink').innerHTML = `${profile[0].firstName} `;
			try {
				document.getElementById('fullName').innerHTML = profile[0].firstName + ' ' + profile[0].lastName;
				document.getElementById('firstName').value = profile[0].firstName;
				document.getElementById('lastName').value = profile[0].lastName;
			} 
			catch (error) {
				
			}
		}
	};
	xhr.send();
};