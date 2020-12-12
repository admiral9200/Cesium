//fetch user profile name
export const getProfile = () => {
	let xhr = new XMLHttpRequest();
	xhr.open('GET', '/php/functions.php?user', true);
	xhr.onload = function(){
		if (this.status == 200) {
			let prof = JSON.parse(this.responseText);
			document.getElementById('dropdownMenuLink').innerHTML = `${prof[0].firstName} <i class='far fa-user'></i>`;
			try {
				document.getElementById('wlcm').innerHTML += prof[0].firstName;
			} 
			catch (error) {
				
			}
		}
	};
	xhr.send();
};