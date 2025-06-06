import { Input, Select, Space } from 'antd';
import { SearchOutlined } from '@ant-design/icons';

const { Option } = Select;

const Filters = ({ searchText, setSearchText, statusFilter, setStatusFilter }) => {
  return (
    <Space style={{ marginBottom: 16 }}>
      <Input
        value={searchText}
        placeholder="Search by username, IP..."
        prefix={<SearchOutlined />}
        onChange={(e) => setSearchText(e.target.value)}
        allowClear
      />
      <Select
        value={statusFilter}
        placeholder="Filter by status"
        onChange={(value) => setStatusFilter(value)}
        style={{ width: 200 }}
      >
        <Option value="">Select</Option>
        <Option value="success">Success</Option>
        <Option value="failed">Failed</Option>
      </Select>
    </Space>
  );
};

export default Filters;
