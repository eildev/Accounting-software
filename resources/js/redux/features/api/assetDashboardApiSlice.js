import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query";

const assetDashboardApiSlice = createApi({
    reducerPath: 'AssetDashboard',
    baseQuery: fetchBaseQuery({ baseUrl: 'http://127.0.0.1:8000/' }),
    endpoints: (builder) => ({
        getData: (builder) => ({
            getAssetTopCard: builder.query({
                query: () => '/asset-dashboard/card-data'
            })
        })
    })
})


export const {
    useGetAssetTopCardQuery
} = assetDashboardApiSlice;

export default assetDashboardApiSlice;