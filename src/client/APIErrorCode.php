<?php

namespace NeutrinoAPI;

/**
 * Neutrino API error codes
 */
class APIErrorCode
{
    public static $INVALID_PARAMETER = 1;
    public static $MAX_CALL_LIMIT = 2;
    public static $BAD_URL = 3;
    public static $ABUSE_DETECTED = 4;
    public static $NOT_RESPONDING = 5;
    public static $CONCURRENT = 6;
    public static $NOT_VERIFIED = 7;
    public static $TELEPHONY_LIMIT = 8;
    public static $INVALID_JSON = 9;
    public static $ACCESS_DENIED = 10;
    public static $MAX_PHONE_CALLS = 11;
    public static $BAD_AUDIO = 12;
    public static $HLR_LIMIT_REACHED = 13;
    public static $TELEPHONY_BLOCKED = 14;
    public static $TELEPHONY_RATE_EXCEEDED = 15;
    public static $FREE_LIMIT = 16;
    public static $RENDERING_FAILED = 17;
    public static $DEPRECATED_API = 18;
    public static $CREDIT_LIMIT_REACHED = 19;
    public static $NOT_MULTI_ENABLED = 21;
    public static $NO_BATCH_MODE = 22;
    public static $BATCH_LIMIT_EXCEEDED = 23;
    public static $BATCH_INVALID = 24;
    public static $USER_DEFINED_DAILY_LIMIT = 31;
    public static $ACCESS_FORBIDDEN = 43;
    public static $REQUEST_TOO_LARGE = 44;
    public static $NO_ENDPOINT = 45;
    public static $INTERNAL_SERVER_ERROR = 51;
    public static $SERVER_OFFLINE = 52;
    public static $CONNECT_TIMEOUT = 61;
    public static $READ_TIMEOUT = 62;
    public static $TIMEOUT = 63;
    public static $DNS_LOOKUP_FAILED = 64;
    public static $TLS_PROTOCOL_ERROR = 65;
    public static $URL_PARSING_ERROR = 66;
    public static $NETWORK_IO_ERROR = 67;
    public static $FILE_IO_ERROR = 68;
    public static $INVALID_JSON_RESPONSE = 69;
    public static $NO_DATA = 70;
    public static $API_GATEWAY_ERROR = 71;

    /**
     * Get description of error code
     *
     * @param int $errorCode APIErrorCode error code
     * @return string A human readable description of error code
     */
    public static function getErrorMessage(int $errorCode): string
    {
        switch ($errorCode) {
            case APIErrorCode::$INVALID_PARAMETER: return "MISSING OR INVALID PARAMETER";
            case APIErrorCode::$MAX_CALL_LIMIT: return "DAILY API LIMIT EXCEEDED";
            case APIErrorCode::$BAD_URL: return "INVALID URL";
            case APIErrorCode::$ABUSE_DETECTED: return "ACCOUNT OR IP BANNED";
            case APIErrorCode::$NOT_RESPONDING: return "NOT RESPONDING. RETRY IN 5 SECONDS";
            case APIErrorCode::$CONCURRENT: return "TOO MANY CONNECTIONS";
            case APIErrorCode::$NOT_VERIFIED: return "ACCOUNT NOT VERIFIED";
            case APIErrorCode::$TELEPHONY_LIMIT: return "TELEPHONY NOT ENABLED ON YOUR ACCOUNT. PLEASE CONTACT SUPPORT FOR HELP";
            case APIErrorCode::$INVALID_JSON: return "INVALID JSON. JSON CONTENT TYPE SET BUT NON-PARSABLE JSON SUPPLIED";
            case APIErrorCode::$ACCESS_DENIED: return "ACCESS DENIED. PLEASE CONTACT SUPPORT FOR ACCESS TO THIS API";
            case APIErrorCode::$MAX_PHONE_CALLS: return "MAXIMUM SIMULTANEOUS PHONE CALLS";
            case APIErrorCode::$BAD_AUDIO: return "COULD NOT LOAD AUDIO FROM URL";
            case APIErrorCode::$HLR_LIMIT_REACHED: return "HLR LIMIT REACHED. CARD DECLINED";
            case APIErrorCode::$TELEPHONY_BLOCKED: return "CALLS AND SMS TO THIS NUMBER ARE LIMITED";
            case APIErrorCode::$TELEPHONY_RATE_EXCEEDED: return "CALL IN PROGRESS";
            case APIErrorCode::$FREE_LIMIT: return "FREE PLAN LIMIT EXCEEDED";
            case APIErrorCode::$RENDERING_FAILED: return "RENDERING FAILED. COULD NOT GENERATE OUTPUT FILE";
            case APIErrorCode::$DEPRECATED_API: return "THIS API IS DEPRECATED. PLEASE USE THE LATEST VERSION";
            case APIErrorCode::$CREDIT_LIMIT_REACHED: return "MAXIMUM ACCOUNT CREDIT LIMIT REACHED. PAYMENT METHOD DECLINED";
            case APIErrorCode::$NOT_MULTI_ENABLED: return "BATCH PROCESSING NOT ENABLED FOR THIS ENDPOINT";
            case APIErrorCode::$NO_BATCH_MODE: return "BATCH PROCESSING NOT AVAILABLE ON YOUR PLAN";
            case APIErrorCode::$BATCH_LIMIT_EXCEEDED: return "BATCH PROCESSING REQUEST LIMIT EXCEEDED";
            case APIErrorCode::$BATCH_INVALID: return "INVALID BATCH REQUEST. DOES NOT CONFORM TO SPEC";
            case APIErrorCode::$USER_DEFINED_DAILY_LIMIT: return "DAILY API LIMIT EXCEEDED. SET BY ACCOUNT HOLDER";
            case APIErrorCode::$ACCESS_FORBIDDEN: return "ACCESS DENIED. USER ID OR API KEY INVALID";
            case APIErrorCode::$REQUEST_TOO_LARGE: return "REQUEST TOO LARGE. MAXIMUM SIZE IS 5MB FOR DATA AND 25MB FOR UPLOADS";
            case APIErrorCode::$NO_ENDPOINT: return "ENDPOINT DOES NOT EXIST";
            case APIErrorCode::$INTERNAL_SERVER_ERROR: return "FATAL EXCEPTION. REQUEST COULD NOT BE COMPLETED";
            case APIErrorCode::$SERVER_OFFLINE: return "SERVER OFFLINE. MAINTENANCE IN PROGRESS";
            case APIErrorCode::$CONNECT_TIMEOUT: return "TIMEOUT OCCURRED CONNECTING TO SERVER";
            case APIErrorCode::$READ_TIMEOUT: return "TIMEOUT OCCURRED READING API RESPONSE";
            case APIErrorCode::$TIMEOUT: return "TIMEOUT OCCURRED DURING API REQUEST";
            case APIErrorCode::$DNS_LOOKUP_FAILED: return "ERROR RECEIVED FROM YOUR DNS RESOLVER";
            case APIErrorCode::$TLS_PROTOCOL_ERROR: return "ERROR DURING TLS PROTOCOL HANDSHAKE";
            case APIErrorCode::$URL_PARSING_ERROR: return "ERROR PARSING REQUEST URL";
            case APIErrorCode::$NETWORK_IO_ERROR: return "IO ERROR DURING API REQUEST";
            case APIErrorCode::$FILE_IO_ERROR: return "IO ERROR WRITING TO OUTPUT FILE";
            case APIErrorCode::$INVALID_JSON_RESPONSE: return "INVALID JSON DATA RECEIVED";
            case APIErrorCode::$NO_DATA: return "NO PAYLOAD DATA RECEIVED";
            case APIErrorCode::$API_GATEWAY_ERROR: return "API GATEWAY ERROR";
            default:
                return sprintf("API Error: %d", $errorCode);
        }
    }
}
