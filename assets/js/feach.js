async function getData(route, params = "") {
    if (params != "") {
      route += `?${params}`;
    }
  		console.log(route)
    let response = await fetch(route);
    
    return await response.json();
  }
  
async function postJSON(route, data, action){
    let response = await fetch(route, {
        method: "POST",
        headers: {
          "Content-Type": "application/json;charset=UTF-8", //обязательный заголовок для формата json
        },
        body: JSON.stringify({data,action}),
      });
      return await response.json()
}
async function postFormData(route, form){
    // console.log(FormData(form))
    let response = await fetch(route, {
        method: "POST",
        // headers: {
        //   "Content-Type": "application/json;charset=UTF-8", //обязательный заголовок для формата json
        // },
        body: new FormData(form),
      });
      return await response.json();
}