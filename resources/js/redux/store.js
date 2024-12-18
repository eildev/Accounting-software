import { configureStore } from "@reduxjs/toolkit";
import mainDashboardApiSlice from "./features/api/mainDashboardApiSlice";

const store = configureStore({
    reducer: {
        [mainDashboardApiSlice.reducerPath]: mainDashboardApiSlice.reducer,
    },
    middleware: (getDefaultMiddleware) =>
        getDefaultMiddleware().concat(mainDashboardApiSlice.middleware),
})

export default store;