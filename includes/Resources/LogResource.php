<?php
namespace Hasinur\LoginActivityTracker\Resources;
/**
 * Class LogResource
 * Represents a contact resource for API responses.
 */
class LogResource extends Resource {
    /**
     * Transform the contact data into an array.
     *
     * @return array
     */
    public function to_array(): array {
        return [
            'id'            => $this->data->id,
            'username'      => $this->data->username,
            'login_status'  => $this->data->login_status,
            'ip_address'    => $this->data->ip_address,
            'location'      => $this->data->location,
            'device'        => $this->data->device,
            'user_agent'    => $this->data->user_agent,
            'created_at'    => $this->data->created_at,
        ];
    }
}
