function validateForm() {
    let x = document.forms["create_auction"]["acutionTitle"].value;
    x.trim();
    if (x == "") {
      alert("Auction Title must be filled out");
      return false;
    }
  }