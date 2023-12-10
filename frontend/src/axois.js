import axios from 'axios';

const API = (self, path, method, params) => {
  const TOKEN = JSON.parse(localStorage.getItem("ACCESS_TOKEN"));
  let base_url = import.meta.env.VITE_BASE_URL;
  try {
    return new Promise(function (myResolve, myReject) {
      if (method == 'get') {
        axios[method](base_url + path, { headers: { Authorization: "Bearer " + TOKEN } })
          .then(response => {
            myResolve(response);
          }).catch(err => {
            myReject(err);
            if (err?.response?.status == 401) {
              expToken();
            }
          })
      }

      if (method == 'post') {
        axios[method](base_url + path, params, { headers: { Authorization: "Bearer " + TOKEN } })
          .then(response => {
            myResolve(response);
          }).catch(err => {
            myReject(err);
            if (err?.response?.status == 401) {
              expToken();
            }
          })
      }
    });
  }
  catch (err) {
    console.error("axios.js >> TOKEN not found", err);
  }
};

function expToken() {
  localStorage.removeItem("ACCESS_TOKEN");
  localStorage.removeItem("LOGIN_TYPE");
  localStorage.removeItem("USER_INFO");
  window.location.replace('');
}

export {
  API,
}