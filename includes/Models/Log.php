<?php
namespace Hasinur\LoginActivityTracker\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Log Model
 *
 * Represents a Log in the phonebook.
 *
 * @package Hasinur\LoginActivityTracker\Models
 * @since 1.0.0
 */
class Log extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'login_activity';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'login_status',
        'ip_address',
        'location',
        'device',
        'user_agent',
    ];
}
