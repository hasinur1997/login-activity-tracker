import apiFetch from '@wordpress/api-fetch';

const BASE = '/login-activity/v1/logs';

/**
 * ContactApi class to handle CRUD operations for contacts.
 * This class provides methods to fetch, create, update, and delete logs.
 */
class LogApi {
  /**
   * Fetch all logs with optional query params.
   *
   * @param   {Object}  args  Query parameters for the request.
   *
   * @return  {Promise}        Promise resolving to the list of logs.
   */
  all(args = {}) {
    const queryString = new URLSearchParams(args).toString();
    const path = queryString ? `${BASE}?${queryString}` : BASE;
    return apiFetch({ path });
  }

  /**
   * Get a single log by ID.
   *
   * @param   {string}  id  The ID of the log to retrieve.
   *
   * @return  {Promise}      Promise resolving to the log data.
   */
  get(id) {
    return apiFetch({ path: `${BASE}/${id}` });
  }

  /**
   * Create a new log.
   *
   * @param   {Object}  data  The log data to create.
   *
   * @return  {Promise}        Promise resolving to the created log data.
   */
  create(data) {
    return apiFetch({
      path: BASE,
      method: 'POST',
      data,
    });
  }

  /**
   * Update log by ID.
   *
   * @param   {string}  id    The ID of the log to update.
   * @param   {Object}  data  The updated log data.
   *
   * @return  {Promise}        Promise resolving to the updated log data.
   */
  update(id, data) {
    return apiFetch({
      path: `${BASE}/${id}`,
      method: 'PUT',
      data,
    });
  }

  /**
   * Delete log by ID.
   *
   * @param   {string}  id  The ID of the log to delete.
   *
   * @return  {Promise}      Promise resolving to the deletion status.
   */
  delete(id) {
    return apiFetch({
      path: `${BASE}/${id}`,
      method: 'DELETE',
    });
  }
}

// Export a single instance
const logApi = new LogApi();
export default logApi;
