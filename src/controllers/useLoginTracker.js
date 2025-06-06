import { useState, useEffect } from "@wordpress/element";
import logApi from "../api/logApi";

const useLoginTracker = () => {
    const [data, setData] = useState([]);
    const [pagination, setPagination] = useState({
        current: 1,
        pageSize: 10,
        showSizeChanger: true,
        pageSizeOptions: ['1', '2', '5', '10', '20', '50'],
    });
    const [loading, setLoading] = useState(true);
    const [searchText, setSearchText] = useState('');
    const [statusFilter, setStatusFilter] = useState('');
    const [sorter, setSorter] = useState({ field: null, order: null });


    const fetchData = async (page = 1) => {
        setLoading(true);
        
        try {
            const response = await logApi.all({ 
                page,
                per_page: pagination.pageSize,
                search: searchText,
                status: statusFilter,
                orderby: sorter.field,
                order: sorter.order,
                filter: statusFilter
            });

            setData(response.data || []);
            setPagination((prev) => ({
                ...prev,
                total: response.total,
            }));
            console.log(response);
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
        setStatusFilter(filters.status || "");
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