app.filter('searchFilter', function() {
  return function(tags, searchText, username) {
    var searchRegx = new RegExp(searchText, "i");
    if ((searchText == undefined) || (username.search(searchRegx) != -1)) {
        return friends;
    }
    var result = [];
    for(i = 0; i < friends.length; i++) {
        if (friends[i].name.search(searchRegx) != -1 || 
            friends[i].age.toString().search(searchText) != -1) {
            result.push(friends[i]);
        }
    }
    return result;
  }
});
