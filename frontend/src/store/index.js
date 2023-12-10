import { createStore } from "vuex";

// Create a new store instance.
export const store = createStore({
  state() {
    return {
      loader: false,
      isLogged: false,
      admin: null,
      token: null,
      isShrink: false,
      primaryNav: false,
      toast: {
        loginFailToast: false,
        loginFailToastText: "",
        loginFailToastArray: false,
        loginFailToastArrayText: "",
        successToast: false,
        successMsg: "",
        warningToast: false,
        warningMsg: "",
        failToast: true,
        failMsg: [],
      },
    };
  },
  getters: {
    accessToken: (state) => state.token,
    shrink: (state) => state.isShrink,
    stateAdmin: (state) => state.admin,
  },
  mutations: {
    loaderShow(state) {
      state.loader = true;
    },
    loaderHide(state) {
      state.loader = false;
    },
    setToken(state, value) {
      state.token = value;
    },
    setAdmin(state, data) {
      state.admin = data;
    },
    isMenuShrink(state, data) {
      state.isShrink = data;
    },

    successToast(state, data) {
      state.toast.successMsg = data.msg;
      state.toast.successToast = data.flag;
    },

    warningToast(state, data) {
      state.toast.warningMsg = data.msg;
      state.toast.warningToast = data.flag;
    },

    failToast(state, data) {
      state.toast.failMsg = data.msg;
      state.toast.failToast = data.flag;
    },

    togglePrimaryNav(state, value) {
      state.primaryNav = value;
    },

    toggleloginFailToast(state, value) {
      state.toast.loginFailToast = value;
    },
    toggleloginFailToastText(state, value) {
      state.toast.loginFailToastText = value;
    },

    toggleloginFailToastArray(state, value) {
      state.toast.loginFailToastArray = value;
    },
    setLoginFailToastArrayText(state, value) {
      state.toast.loginFailToastArrayText = value;
    },
    logOut(state) {
      state.admin = null;
    },
  },
  actions: {
    SuccessToast({ commit }, payload) {
      let data = {
        msg: payload.message,
        flag: true,
      };
      commit("successToast", data);
      setTimeout(() => {
        data.msg = "";
        data.flag = false;
        commit("successToast", data);
      }, 3000);
    },

    WarningToast({ commit }, payload) {
      let data = {
        msg: payload.message,
        flag: true,
      };
      commit("warningToast", data);
      setTimeout(() => {
        data.msg = "";
        data.flag = false;
        commit("warningToast", data);
      }, 3000);
    },

    FailToast({ commit }, payload) {
      let data = {
        msg: payload.message,
        flag: true,
      };
      commit("failToast", data);
      setTimeout(() => {
        data.msg = [];
        data.flag = false;
        commit("failToast", "", data);
      }, 3000);
    },

    loginSuccesToast({ commit }) {
      commit("toggleloginSuccesToast", true);
      setTimeout(() => {
        commit("toggleloginSuccesToast", false);
      }, 3000);
    },

    loginFailToast({ commit }, payload) {
      commit("toggleloginFailToastText", payload.message);

      commit("toggleloginFailToast", true);
      setTimeout(() => {
        commit("toggleloginFailToast", false);
      }, 3000);
    },

    loginFailToastArray({ commit }, payload) {
      commit("toggleloginFailToastArray", true);
      commit("setLoginFailToastArrayText", payload.message);
      setTimeout(() => {
        commit("toggleloginFailToastArray", false);
      }, 3000);
    },

    isAuthentic({ commit }) {
      try {
        const token = localStorage.getItem("ACCESS_TOKEN");
        if (token) {
          commit("setToken", token);
        }
      } catch (err) {
        console.error("🚀 ~ file: index.js ~ isAuthentic ~ err", err)
      }
    },
  },
});
