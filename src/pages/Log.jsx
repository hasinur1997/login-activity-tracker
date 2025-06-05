import useLoginTracker  from '../controllers/useLoginTracker';
import LoginTable from '../components/LogTable';
import Filters from '../components/Filters';

const Log = () => {
    const {
        data,
        loading,
        pagination,
        searchText,
        setSearchText,
        statusFilter,
        setStatusFilter,
        onChangeTable,
    } = useLoginTracker();

    return (
        <div>
            <h2>Log Page</h2>
            <Filters
                searchText={searchText}
                setSearchText={setSearchText}
                statusFilter={statusFilter}
                setStatusFilter={setStatusFilter}
            />
            <LoginTable
                data={data}
                loading={loading}
                pagination={pagination}
                onChange={onChangeTable}
            />
        </div>
    );
}

export default Log;
