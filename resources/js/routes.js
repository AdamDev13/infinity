import Dashboard from './views/Dashboard.vue'
import Projects from './views/Projects.vue'
import FavoritedProjects from './views/FavoritedProjects.vue'
import Clients from './views/Clients.vue'
import Users from './views/Users.vue'
import Settings from './views/Settings.vue'
import AddProject from './views/AddProject.vue'
import AddClient from './views/AddClient.vue'
import EditUser from './views/EditUser.vue'
import MyProfile from './views/MyProfile.vue'
import EditClient from './views/EditClient.vue'
import EditProject from './views/EditProject.vue'
import ViewProject from './views/ViewProject.vue'
import Login from './views/Login.vue'
import CreateAccount from './views/CreateAccount.vue'
import SearchPreferences from './views/SearchPreferences.vue'
import NotFound from './views/NotFound.vue'
import RecentProjects from './views/RecentProjects.vue'
import BidSubmissions from './views/BidSubmissions.vue'
import ProjectQuestions from './views/ProjectQuestions.vue'
import ResetPassword from './views/ResetPassword.vue'
import {createRouter, createWebHistory} from "vue-router";
import store from './store';
import ForgetPassword from "./views/ForgetPassword";
import ForgotResetPassword from "./views/ForgotResetPassword";

/** @type {import('vue-router').RouterOptions['routes']} */
export const routes = [
    {
        name:"dashboard",
        path: '/',
        component: Dashboard,
        meta: {
            title: 'Dashboard',
            middleware:"auth"
        }
    },
    {
        path: '/settings',
        meta: { title: 'Settings' },
        component: Settings,
    },
    {
        name:"login",
        path: '/login',
        meta: {
            title: 'Login',
            middleware:"guest",
        },
        component: Login,
    },
    {
        path: '/create-account',
        component: CreateAccount,
        meta:{
            title: 'Create Account',
            middleware:"guest"
        }
    },
    {
        path: '/projects',
        meta: { title: 'Projects' },
        component: Projects,
    },
    {
        path: '/favorited-projects',
        meta: { title: 'Favorited Projects' },
        component: FavoritedProjects,
    },
    {
        path: '/users',
        meta: { title: 'Users' },
        component: Users,
    },
    {
        path: '/clients',
        meta: { title: 'Clients' },
        component: Clients,
    },
    {
        path: '/add-project',
        meta: { title: 'Add Project' },
        component: AddProject,
    },
    {
        path: '/add-client',
        meta: { title: 'Add Client' },
        component: AddClient,
    },
    {
        path: '/edit-user',
        meta: { title: 'Edit User' },
        component: EditUser,
    },
    {
        path: '/profile',
        meta: { title: 'My Profile' },
        component: MyProfile,
    },
    {
        path: '/edit-client',
        meta: { title: 'Edit Client' },
        component: EditClient,
    },
    {
        path: '/edit-project',
        meta: { title: 'Edit Project' },
        component: EditProject,
    },
    {
        path: '/view-project/:id',
        meta: { title: 'View Project' },
        component: ViewProject,
    },
    {
        path: '/search-prefrences',
        meta: { title: 'Search Prefrences' },
        component: SearchPreferences,
    },
    {
        path: '/recent-projects',
        meta: { title: 'Recent Projects' },
        component: RecentProjects,
    },
    {
        path: '/bid-submissions',
        meta: { title: 'Bid Submissions' },
        component: BidSubmissions,
    },
    {
        path: '/project-questions',
        meta: { title: 'Project Questions' },
        component: ProjectQuestions,
    },
    {
        path: '/reset-password',
        meta: { title: 'Reset Password' },
        component: ResetPassword,
    },
    {
        path: '/forgot-password',
        meta: { title: 'Forgot Password', middleware:"guest" },
        component: ForgetPassword,
    },
    {
        path: '/forgot-password/:token/:email',
        meta: { title: 'Forgot Password', middleware:"guest" },
        component: ForgotResetPassword,
    },
    { path: '/:path(.*)', component: NotFound },
]
const router = createRouter({
    history: createWebHistory(),
    routes,
})


router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title} - ${process.env.MIX_APP_NAME}`

        // store.dispatch("auth/authUser").then(() => {
        //     if (!store.state.auth.authenticated) next({name:"login"});
        // });

    const isAuthenticated = store.getters['auth/authenticated'];

    if(to.meta.middleware=="guest"){
        if(isAuthenticated){
            next({name:"dashboard"})
        }
        next()
    }else{
        if(isAuthenticated){
            next()
        }else{
            next({name:"login"})
        }
    }
})


export default router;
