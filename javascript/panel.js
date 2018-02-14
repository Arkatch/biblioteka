window.addEventListener('load', defaultWindow);


function defaultWindow(){
	document.getElementById('addBook').addEventListener('click', createAddBook);
	document.getElementById('wypBook').addEventListener('click', createBorrowBook);
	document.getElementById('editBook').addEventListener('click', createEditBook);
	document.getElementById('raport').addEventListener('click', raportBook);
	document.getElementById('statyst').addEventListener('click', statBook);
	document.getElementById('list').addEventListener('click', listAllBook);
	document.getElementById('archiwum').addEventListener('click', archBuild);
	
	document.getElementById('wypBook').style.backgroundColor = "#155555";
	
	document.getElementById('wypBook').click();
	
	var elems = document.querySelectorAll('#jsPanel .but');
	for(var x of elems){
		x.addEventListener('click', function(){ setColor(this, elems);})
	}
	
}
function setColor(elem, elems){
	for(var x of elems){
		x.style.backgroundColor =  "#555555";
	}
	document.getElementById('logOut').style.backgroundColor = "#008CBA";
	elem.style.backgroundColor =  "#155555";
}
function createAddBook(){
	var mainContext = document.getElementById("javascriptContext");
	while (mainContext.firstChild) {
		mainContext.removeChild(mainContext.firstChild);
	}
	var x = document.querySelector("head > link");
	x.setAttribute("href", "../css/addbook.css");	
	var mainDiv = document.createElement("div");
	mainDiv.innerHTML = '<form name="newBook" onsubmit="return addNewBookVal()"  enctype="multipart/form-data" method="post" action="../php/addNewBook.php"> <div id="formGird"> <div id="bookNameId"> <input id="bookNameFocus" type="text" name="bookName" placeholder="Nazwa książki" > </div>  <div id="autorBookId"> <input type="text" name="autorBook" placeholder="Autor" > </div>  <div id="descBookId"> <textarea name="descBook" placeholder="Opis książki"></textarea> </div>  <div id="amountBookId"> <input type="number" name="amountBook" min="1" placeholder="Ilość sztuk" > </div>  <div id="imgUpload"> Wybierz zdjęcie <input type="file" name="fileToUpload" > </div>  <div id="submitButtonId"> <input class="but" type="submit" name="send" value="Dodaj książkę"> </div> </div> </form>';
	mainContext.appendChild(mainDiv);
	
	document.getElementById('bookNameFocus').focus();
}
function addNewBookVal(){
	var book = document.forms.newBook.bookName.value;
	var autor = document.forms.newBook.autorBook.value;
	var opis = document.forms.newBook.descBook.value;
	var ilosc = document.forms.newBook.amountBook.value;
	var zdj = document.forms.newBook.fileToUpload.value;
	var raport = "";
	if(book==""){
		raport+="Nie wpisano nazwy książki! \n"
	}
	if(autor==""){
		raport+="Nie wpisano autora! \n";
	}
	if(opis==""){
		raport+="Nie wpisano opisu! \n";
	}
	if(ilosc==""){
		raport+="Nie wpisano liczby książek! \n";
	}
	if(zdj==""){
		raport+="Nie wybrano zdjęcia! \n";
	}
	if(raport){
		alert(raport);
		return false;
	}
	return true;
}
function createBorrowBook(){
	var mainContext = document.getElementById("javascriptContext");
	while (mainContext.firstChild) {
		mainContext.removeChild(mainContext.firstChild);
	}
	var x = document.querySelector("head > link");
	x.setAttribute("href", "../css/borrowbook.css");
	var mainDiv = document.createElement("div");
	
	var phpCom = new XMLHttpRequest();
    phpCom.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200){
			var temp = phpCom.responseText;
				mainDiv.innerHTML = '<form name="newBook" onsubmit="return borrowBookVal()" method="post" action="../php/wypozycz.php" > <div id="formGird"> <div id="borrowBookId"> Data wypożyczenia książki<br> <input type="date" name="dataWypoz" value=""> </div>  <div id="imieNazwiskoId"> <input id="imieFocus" type="text" name="imienazwisko" placeholder="Imię i nazwisko" value=""> </div>  <div id="klasaId"> <input type="text" name="klasa" placeholder="Klasa" value=""> </div>  <div id="ksiazkaId"> <select name="idKsiazki" size=""> <option value="0">Wybierz książkę</option> '+temp+' </select> </div> <div id="submitButtonId"> <input class="but" type="submit" name="send" value="Wypożycz"> </div> </div> </form>';
				mainContext.appendChild(mainDiv);
				var now = new Date();
				var day = ("0" + now.getDate()).slice(-2);
				var month = ("0" + (now.getMonth() + 1)).slice(-2);
				var today = now.getFullYear()+"-"+(month)+"-"+(day);
				document.forms.newBook.dataWypoz.value = today;
				document.getElementById('imieFocus').focus();
        };	
	};
	phpCom.open("POST", "../php/listBook.php", true);
	phpCom.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	phpCom.send();
}
function borrowBookVal(){
	var data = document.forms.newBook.dataWypoz.value;
	var imie = document.forms.newBook.imienazwisko.value;
	var klasa = document.forms.newBook.klasa.value;
	var ksiazka = document.forms.newBook.idKsiazki.value;
	var raport = "";
	if(data==""){
		raport+="Nie wybrano daty! \n"
	}
	if(imie==""){
		raport+="Nie wpisano imienia i nazwiska  ucznia! \n";
	}
	if(klasa==""){
		raport+="Wpisz klasę ucznia! \n";
	}
	if(ksiazka=="0"){
		raport+="Nie wybrano książki! \n";
	}
	if(raport){
		alert(raport);
		return false;
	}
	return true;
}
function createEditBook(){
	var mainContext = document.getElementById("javascriptContext");
	while (mainContext.firstChild) {
		mainContext.removeChild(mainContext.firstChild);
	}
	var x = document.querySelector("head > link");
	x.setAttribute("href", "../css/editbook.css");
	var phpCom = new XMLHttpRequest();
    phpCom.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200){
			var temp = phpCom.responseText;
				var mainDiv = document.createElement("div");
				mainDiv.innerHTML = '<div id="ksiazkaId"> <select id="getBook" name="idKsiazki" size=""> <option value="0">Wybierz książkę</option>'+temp+'</select> <input id="gridBut" class="but" type="button" value="Edytuj" onclick="ajaxGetBook()"> </div> <form name="editBook"  enctype="multipart/form-data" method="post" action="../php/editBook.php">  <div id="ajaxBook"> <div id="bookId"> <input id="bookIdJ" type="text" name="bookIdF" > </div> <div id="bookNameId">Tytuł książki<br><input type="text" name="bookName" placeholder="Nazwa książki"> </div> <div id="autorBookId">Autor książki<br><input type="text" name="autorBook" placeholder="Autor" > </div> <div id="descBookId"> <textarea name="descBook" placeholder="Opis książki"></textarea> </div> <div id="amountBookId">Liczba książek<br><input type="number" name="amountBook" min="1" placeholder="Ilość sztuk" > </div> <div id="imgUpload">Wybierz zdjęcie <br> <span id="oblique">W przypadku nie wybrania nowego zdjęcia, pozostaje stare. </span><br><input type="file" name="fileToUpload" > <input id="oldImg" name="oldImgF" type="text" value=""> </div> <div id="submitButtonId"> <input class="but" type="submit" name="send" value="Zatwierdź"> </div>  </div>  </form>';
				mainContext.appendChild(mainDiv);
        };	
	};
	phpCom.open("POST", "../php/listBook.php", true);
	phpCom.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	phpCom.send();

}
function write(tab){
	var tytul = document.querySelector('#bookNameId > input');
	var autor = document.querySelector('#autorBookId > input');
	var opis = document.querySelector('#descBookId > textarea');
	var ilosc = document.querySelector('#amountBookId > input');
	var stareZdjcie = document.querySelector('#oldImg');
	var idKsiazki = document.querySelector('#bookIdJ');
	tytul.value = tab[0];
	autor.value = tab[1];
	opis.value = tab[2];
	ilosc.value = parseInt(tab[3]);
	stareZdjcie.value = tab[4];
	idKsiazki.value = parseInt(tab[5]);
}
function ajaxGetBook(){
	//pobiera dane o książce z serwera
	var id = document.getElementById('getBook').value;
	if(id>0){
		var phpCom = new XMLHttpRequest();
		phpCom.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200){
				var temp = phpCom.responseText;
				var tab = temp.split('|');
				write(tab);
			};	
		};
		phpCom.open("POST", "../php/ajaxGetBook.php", true);
		phpCom.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		phpCom.send("id="+id);	
	}
}
function raportBook(){
	var mainContext = document.getElementById("javascriptContext");
	while (mainContext.firstChild) {
		mainContext.removeChild(mainContext.firstChild);
	}
	var x = document.querySelector("head > link");
	x.setAttribute("href", "../css/raport.css");
		var phpCom = new XMLHttpRequest();
		phpCom.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200){
				var temp = phpCom.responseText;
				var x = document.createElement('div');
				x.innerHTML = temp;
				mainContext.appendChild(x);
			};	
		};
		phpCom.open("POST", "../php/raport.php", true);
		phpCom.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		phpCom.send();
}
function ajaxDelRecord(id){
		if(confirm("Potwierdź oddanie książki.")){
			var phpCom = new XMLHttpRequest();
			ajaxArchUpdate(id);
			phpCom.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200){
					raportBook();
				};	
			};
			phpCom.open("POST", "../php/delRecord.php", true);
			phpCom.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			phpCom.send("id="+id);
		}
}
function ajaxArchUpdate(id){
	var phpCom = new XMLHttpRequest();
	phpCom.onreadystatechange = function() {
	if (this.readyState == 4 && this.status == 200){
		console.log(phpCom.responseText);
		};	
	};
	phpCom.open("POST", "../php/addBookToArch.php", true);
	phpCom.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	phpCom.send("id="+id);
}
function statBook(){
	var mainContext = document.getElementById("javascriptContext");
	while (mainContext.firstChild) {
		mainContext.removeChild(mainContext.firstChild);
	}
	var x = document.querySelector("head > link");
	x.setAttribute("href", "../css/statystyka.css");
	var phpCom = new XMLHttpRequest();
		phpCom.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200){
				var temp = phpCom.responseText;
				var x = document.createElement('div');
				x.innerHTML = temp;
				mainContext.appendChild(x);
			};	
		};
		phpCom.open("POST", "../php/statystyka.php", true);
		phpCom.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		phpCom.send();
}
function listAllBook(){
	var mainContext = document.getElementById("javascriptContext");
	while (mainContext.firstChild) {
		mainContext.removeChild(mainContext.firstChild);
	}
	var x = document.querySelector("head > link");
	x.setAttribute("href", "../css/listallbook.css");
	
	var phpCom = new XMLHttpRequest();
	phpCom.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200){
			
			var temp = phpCom.responseText;
			var x = document.createElement('div');
			x.innerHTML = listAllBookArray(temp);
			mainContext.appendChild(x);
			
		};	
	};
	phpCom.open("POST", "../php/ajaxAllBookList.php", true);
	phpCom.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	phpCom.send();
}
function listAllBookArray(tab){
	var tab = tab.split("---");
	tab.pop();
	var tabInner = "<div id='firstDiv' class='cont'><div class='tytul'>Tytuł</div><div class='autor'>Autor</div><div class='wszystkie'>Liczba wszystkich książek</div><div class='dostepne'>Liczba dostępnych książek</div> <div class='stat'>Książkę wypożyczono</div> <div class='usun'>Operacje</div> </div>";
	for(let i=0, j=tab.length;i<j;i++){
		var temp = tab[i].split("|");
		if(temp[3]>0){
			tabInner+="<div class='cont'><div class='tytul'>"+temp[0]+"</div><div class='autor'>"+temp[1]+"</div><div class='wszystkie'>"+temp[2]+"</div><div class='dostepne'>"+temp[3]+"</div> <div class='stat'>"+temp[4]+"</div> <div class='usun'><input id="+temp[5]+" type='button' value='Usuń książkę' class='but' onclick='delBook(this.id)' />  <input id="+temp[5]+" type='button' value='Edytuj' class='but' onclick='editBookFromList(this.id)' /> </div> </div>";
		}else{
			tabInner+="<div class='cont'><div class='tytul'>"+temp[0]+"</div><div class='autor'>"+temp[1]+"</div><div class='wszystkie'>"+temp[2]+"</div><div class='dostepneRed'>"+temp[3]+"</div> <div class='stat'>"+temp[4]+"</div><div class='usun'><input id="+temp[5]+" type='button' value='Usuń książkę' class='but' onclick='delBook(this.id)' /><input id="+temp[5]+" type='button' value='Edytuj' class='but' onclick='editBookFromList(this.id)' /></div> </div>";
		}
	}
	return tabInner;
}
function delBook(id){
	if(confirm("Czy napewno chcesz usunąć?")){
	var request = new XMLHttpRequest();
	request.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200){
			listAllBook();
		};	
	};
	request.open("POST", "../php/delBook.php", true);
	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	request.send("id="+id);
	}
}
function editBookFromList(id){
	if(confirm("Czy edytować?")){
	var x = document.querySelector("head > link");
	x.setAttribute("href", "../css/neweditbook.css");
	
	var mainContext = document.getElementById("javascriptContext");
	mainContext.innerHTML = '<div id="ksiazkaId"><form name="editBook"  enctype="multipart/form-data" method="post" action="../php/editBook.php">  <div id="ajaxBook"> <div id="bookId"> <input id="bookIdJ" type="text" name="bookIdF" > </div> <div id="bookNameId">Tytuł książki<br><input type="text" name="bookName" placeholder="Nazwa książki"> </div> <div id="autorBookId">Autor książki<br><input type="text" name="autorBook" placeholder="Autor" > </div> <div id="descBookId"> <textarea name="descBook" placeholder="Opis książki"></textarea> </div> <div id="amountBookId">Liczba książek<br><input type="number" name="amountBook" min="1" placeholder="Ilość sztuk" > </div> <div id="imgUpload">Wybierz zdjęcie <br> <span id="oblique">W przypadku nie wybrania nowego zdjęcia, pozostaje stare. </span><br><input type="file" name="fileToUpload" > <input id="oldImg" name="oldImgF" type="text" value=""> </div> <div id="submitButtonId"> <input class="but" type="submit" name="send" value="Zatwierdź"> </div>  </div>  </form>';

	var phpCom = new XMLHttpRequest();
	phpCom.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200){
			var temp = phpCom.responseText;
			var tab = temp.split('|');
			write(tab);
		};	
	};
	phpCom.open("POST", "../php/ajaxGetBook.php", true);
	phpCom.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	phpCom.send("id="+id);
	}
}


function archBuild(){
	var mainContext = document.getElementById("javascriptContext");
	while (mainContext.firstChild) {
		mainContext.removeChild(mainContext.firstChild);
	}
	var x = document.querySelector("head > link");
	x.setAttribute("href", "../css/archiwum.css");
	
	var phpCom = new XMLHttpRequest();
	phpCom.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200){
			
			var temp = phpCom.responseText;
			var x = document.createElement('div');
			x.innerHTML = temp;
			mainContext.appendChild(x);
			
		};	
	};
	phpCom.open("POST", "../php/archiwum.php", true);
	phpCom.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	phpCom.send();
}
function ajaxDelRecordFromArch(id){
	if(confirm("Uwaga! To usunie również rekord z archiwum! Czy napewno chcesz usunąć?")){
		var phpCom = new XMLHttpRequest();
		phpCom.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200){
				raportBook();		
			};	
		};
		phpCom.open("POST", "../php/delRecordFromArch.php", true);
		phpCom.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		phpCom.send("id="+id);
	}
}