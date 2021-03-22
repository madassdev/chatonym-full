import Feed from "../views/Feed";
import Fad from "../views/Fad";

export const routes = [
    {
        path: "/",
        name: "Hello",
        component: Feed
    },
    {
        path: "/feeda",
        name: "Feeds",
        component: Feed
    },
    {
        path: "/fad",
        name: "fa",
        component: Fad
    },
    {
        path: "/rand",
        name: "hhh",
        component: Feed
    }
];
