import { useState, useEffect } from "@wordpress/element";
import apiFetch from "@wordpress/api-fetch";

const useLoginTracker = () => {
    const [data, setData] = useState([]);
    const [pagination, setPagination] = useState({
        total: 0,
        perPage: 10,
        currentPage: 1,
    });
    const [loading, setLoading] = useState(true);
    const [searchText, setSearchText] = useState("");
    const [statusFilter, setStatusFilter] = useState(null);
    const [sorter, setSorter] = useState({ field: null, order: null });


    const fetchData = async (page = 1) => {
        setLoading(true);
        
        try {
            const response = await apiFetch({ 'path': '/login-activity/v1/logs'});

            setData(response.data || []);
            setPagination((prev) => ({
                ...prev,
                total: response.total,
            }));

        }catch (error) {
            console.error("Error fetching data:", error);
        }finally {
            setLoading(false);
        }
    }

    useEffect(() => {
        fetchData(pagination.currentPage);
    }, [pagination.currentPage, searchText, statusFilter, sorter]);

    const onChangeTable = (pagination, filters, sorter) => {
        setPagination({
            ...pagination,
            currentPage: pagination.current,
        });
        setStatusFilter(filters.status || null);
        setSearchText(filters.search || "");
        setSorter({
            field: sorter.field,
            order: sorter.order,
        });
    };

    return {
        data,
        loading,
        pagination,
        searchText,
        setSearchText,
        statusFilter,
        setStatusFilter,
        onChangeTable,
    };
}

export default useLoginTracker;