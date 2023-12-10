import { createRouter, createWebHashHistory } from "vue-router";
import { i18n } from "../main";

import AuthLayout from "../layout/admin-layout/AuthLayout.vue";
import DashboardLayout from "../layout/admin-layout/DashboardLayout.vue";
import ResLayout from "../layout/res-layout/ResDashboard.vue";

// ADMIN_DASHBOARD Layout Pages
import {
  Finance,
  Login as AdminLogin,
  Store,
  CompanyRegistration,
  EditCompany,
  AwaitingApproval,
  ActiveDeliverers,
  BlockedDeliverers,
  AdminRegistration,
  GenSettings,
  MasterUsers,
  NotiSystem,
  RatingQuestion,
  ResturantQuestion,
  RidOrdCanQuestion,
  ValuesDistance,
  Reports,
  Regions,
  Branches,
  AllBranches,
  Occurrences,
  RiderOccurences,
  RankingEvaluation,
  RiderRating,
  Home,
  AdminProfile,
  ChatView,
  OrderDetails,
  RiderDetails,
  Addresses as ViewAddresses
} from "../views/admin-dashboard";

// RES_DASHBOARD layout pages
import {
  Home as ResDashboard,
  StoreLogin,
  UpdatePassword,
  ForgetPassword,
  RecoverPassword,
  ResReports,
  ResFinance,
  CreditCard,
  StoreBranches,
  Profile,
  Addresses,
  SingleOrder,
} from "../views/res-dashboard";

const routes = [
  {
    path: "/",
    redirect: "/",
    component: DashboardLayout,
    children: [
      {
        path: "/",
        name: "Home",
        components: { default: Home },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/riders/awaiting-approval",
        name: "Awaiting Approval",
        components: { default: AwaitingApproval },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/riders/active-deliveries",
        name: "ActiveDeliverers",
        components: { default: ActiveDeliverers },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/riders/blocked-deliveries",
        name: "BlockedDeliverers",
        components: { default: BlockedDeliverers },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/riders/occurrences",
        name: "Occurrences",
        components: { default: Occurrences },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/riders/rider-occurrences/:id",
        name: "RiderOccurences",
        components: { default: RiderOccurences },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/riders/ranking",
        name: "RankingEvaluation",
        components: { default: RankingEvaluation },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/riders/ranking/:id",
        name: "RiderRanking",
        components: { default: RiderRating },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/store",
        name: "Store",
        components: { default: Store },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/company-registration",
        name: "CompanyRegistration",
        components: { default: CompanyRegistration },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/company-registration/:id",
        name: "EditCompany",
        components: { default: EditCompany },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/store-branches/:id",
        name: "Branches",
        components: { default: Branches },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/store/all-branches",
        name: "AllBranches",
        components: { default: AllBranches },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/settings/general-settings",
        name: "GenSettings",
        components: { default: GenSettings },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/settings/values-by-distance",
        name: "ValuesDistance",
        components: { default: ValuesDistance },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/settings/notification",
        name: "NotiSystem",
        components: { default: NotiSystem },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/settings/master-users",
        name: "MasterUsers",
        components: { default: MasterUsers },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/settings/rider-question",
        name: "RatingQuestion",
        components: { default: RatingQuestion },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/settings/resturant-question",
        name: "ResturantQuestion",
        components: { default: ResturantQuestion },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/settings/order-cancel-question",
        name: "RidOrdCanQuestion",
        components: { default: RidOrdCanQuestion },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/settings/regions",
        name: "Regions",
        components: { default: Regions },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/finance",
        name: "Finance",
        components: { default: Finance },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/reports",
        name: "Reports",
        components: { default: Reports },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/admin-profile",
        name: "AdminProfile",
        components: { default: AdminProfile },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/chat",
        name: "ChatView",
        components: { default: ChatView },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/addresses",
        name: "ViewAddresses",
        components: { default: ViewAddresses },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/order-details/:id",
        name: "OrderDetails",
        components: { default: OrderDetails },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/rider-detials/:id",
        name: "RiderDetails",
        components: { default: RiderDetails },
        meta: { requiresAuth: true, type: "ADMIN_DASHBOARD" },
      },
    ],
  },
  {
    path: "/",
    redirect: "/resturant-dashboard",
    component: ResLayout,
    children: [
      {
        path: "/resturant-dashboard",
        name: "ResDashboard",
        components: { default: ResDashboard },
        meta: { requiresAuth: true, type: "RES_DASHBOARD" },
      },
      {
        path: "/order/:id",
        name: "SingleOrder",
        components: { default: SingleOrder },
        meta: { requiresAuth: true, type: "RES_DASHBOARD" },
      },
      {
        path: "/report",
        name: "ResReports",
        components: { default: ResReports },
        meta: { requiresAuth: true, type: "RES_DASHBOARD" },
      },
      {
        path: "/resturant-finance",
        name: "ResFinance",
        components: { default: ResFinance },
        meta: { requiresAuth: true, type: "RES_DASHBOARD" },
      },
      {
        path: "/credit-card",
        name: "CreditCard",
        components: { default: CreditCard },
        meta: { requiresAuth: true, type: "RES_DASHBOARD" },
      },
      {
        path: "/store-branches",
        name: "StoreBranches",
        components: { default: StoreBranches },
        meta: { requiresAuth: true, type: "RES_DASHBOARD" },
      },
      {
        path: "/profile",
        name: "Profile",
        components: { default: Profile },
        meta: { requiresAuth: true, type: "RES_DASHBOARD" },
      },
      {
        path: "/view-addresses",
        name: "Addresses",
        components: { default: Addresses },
        meta: { requiresAuth: true, type: "RES_DASHBOARD" },
      },
    ],
  },
  {
    path: "/",
    redirect: "/login",
    component: AuthLayout,
    children: [
      {
        path: "/login",
        name: "AdminLogin",
        components: { default: AdminLogin },
        meta: { requiresAuth: false, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/admin-registration",
        name: "AdminRegistration",
        components: { default: AdminRegistration },
        meta: { requiresAuth: false, type: "ADMIN_DASHBOARD" },
      },
      {
        path: "/store-login",
        name: "StoreLogin",
        components: { default: StoreLogin },
        meta: { requiresAuth: false, type: "RES_DASHBOARD" },
      },
      {
        path: "/forget-password",
        name: "ForgetPassword",
        components: { default: ForgetPassword },
        meta: { requiresAuth: false, type: "RES_DASHBOARD" },
      },
      {
        path: "/deliverer-recover-password/:token",
        name: "RecoverPassword",
        components: { default: RecoverPassword },
        meta: { requiresAuth: false, type: "RES_DASHBOARD" },
      },
      {
        path: "/update-password/:Token",
        sensitive: true,
        name: "upUpdatePassword",
        components: { default: UpdatePassword },
        meta: { requiresAuth: false, type: "RES_DASHBOARD" },
      },
    ],
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  linkActiveClass: "active",
  routes,
});

router.beforeEach((to, from, next) => {
  i18n.locale = localStorage.getItem("language")
    ? localStorage.getItem("language")
    : "en";
  let TOKEN = localStorage.getItem("ACCESS_TOKEN");
  let TYPE = localStorage.getItem("LOGIN_TYPE");
  let META_TYPE = to.meta.type;
  if (to.meta.requiresAuth == true) {
    if (!!TOKEN && META_TYPE == JSON.parse(TYPE)) {
      next();
    } else {
      console.warn("not authenticated");
      next("/login");
    }
  } else {
    next();
  }
});

export default router;
