import { Table, Tag} from "antd";

const LogTable = ({ data, loading, pagination, onChange }) => {
  const columns = [
    {
      title: 'Username',
      dataIndex: 'username',
      sorter: true,
    },
    {
      title: 'Status',
      dataIndex: 'login_status',
      filters: [
        { text: 'Success', value: 'success' },
        { text: 'Failed', value: 'failed' },
      ],
      render: (status) => (
        <Tag color={status === 'success' ? 'green' : 'red'}>
          {status.toUpperCase()}
        </Tag>
      ),
    },
    { title: 'IP', dataIndex: 'ip', sorter: true },
    { title: 'Location', dataIndex: 'location' },
    { title: 'Device', dataIndex: 'device' },
    { title: 'User Agent', dataIndex: 'user_agent' },
    { title: 'Time', dataIndex: 'time', sorter: true },
  ];

  return (
    <Table
      rowKey="id"
      columns={columns}
      dataSource={data}
      pagination={pagination}
      loading={loading}
      onChange={onChange}
    />
  );
};

export default LogTable;
