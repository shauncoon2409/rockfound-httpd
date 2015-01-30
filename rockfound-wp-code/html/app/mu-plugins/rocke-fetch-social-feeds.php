<?php
/**
 * Rocke Fetch Social Feeds
 * 
 * Get Twitter and Instagram account feeds for provided users.
 * 
 * @package WordPress
 * @subpackage rocke_fetch_social_feeds
 */

if (   file_exists($composer_autoload = __DIR__ . '/vendor/autoload.php') 
	|| file_exists($composer_autoload = WP_CONTENT_DIR.'/vendor/autoload.php')
   )
{
  require_once($composer_autoload);
}

use MetzWeb\Instagram\Instagram;

class Rocke_social_feeds {


	public function __construct() {
		$this->instagram_api = new Instagram(getenv('INSTAGRAM_CLIENT_ID'));

		$this->twitter_api = new TwitterAPIExchange(array(
			'oauth_access_token' 		=> getenv('TWITTER_ACCESS_TOKEN'),
			'oauth_access_token_secret' => getenv('TWITTER_ACCESS_SECRET'),
			'consumer_key' 				=> getenv('TWITTER_CONSUMER_KEY'),
			'consumer_secret' 			=> getenv('TWITTER_CONSUMER_SECRET'),
		));

		phpFastCache::setup("storage","auto");

		$this->cache_expire = 600;
		$this->cache = phpFastCache();
	}

	public function clean_cache() {
		$this->cache->clean();
	}

	// ---------------------------------
	// Get aggregate social feeds.
	// ---------------------------------
	public function get_social_feeds($twitter = '', $instgram = '', $count = 5 )
	{
		$twitter_accounts = explode(',', $twitter);
		$instgram_accounts = explode(',', $instgram);

		$feed = array();
		
		if ( !empty($twitter_accounts) )
		{
			foreach ($twitter_accounts as $user) {
				$feed = array_merge($feed, $this->get_twitter_feed($user, $count));
			}
		}

		if ( !empty($instgram_accounts) )
		{
			foreach ($instgram_accounts as $user) {
				$feed = array_merge($feed, $this->get_instagram_feed($user, $count));
			}
		}

		usort( $feed, array("Rocke_social_feeds", "sort_feed") );

		return $feed;
	}



	// ---------------------------------
	// Get Twitter Feeds
	// ---------------------------------
	public function get_twitter_feed($screen_name, $count = 5) {
		$cache_key = "twitter_" . $screen_name;
		$cache = $this->cache->get($cache_key);

		if ( $cache != null )
		{
			return $this->_format_result('twitter', $cache);
		}

		$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		$params = '?' . http_build_query(array('screen_name' => $screen_name, 'count' => $count));
		$response = $this->twitter_api->setGetfield($params)->buildOauth($url, 'GET')->performRequest();

		$this->cache->set($cache_key, json_decode($response), $this->cache_expire);

		return $this->_format_result('twitter', json_decode($response));
	}



	// ---------------------------------
	// Get Instagram Feed
	// ---------------------------------
	public function get_instagram_feed($user_id, $count = 5) {
		$cache_key = "instagram_" . $user_id;
		$cache = $this->cache->get($cache_key);

		if ( $cache != null )
		{
			return $this->_format_result('instgram', $cache);
		}

		// Fetch Instagram UserID if needed.
		if ( ! is_numeric($user_id) )
		{
			$user_id = $this->get_instagram_userid($user_id);
		}

		$data = array();

		$result = $this->instagram_api->getUserMedia($user_id, $count);

		if ( isset($result->data) )
		{
			$data = $result->data;
			$this->cache->set($cache_key, $result->data, $this->cache_expire);
		}
		
		return $this->_format_result('instgram', $data);
	}



	// ---------------------------------
	// Get Instagram User ID
	// ---------------------------------
	public function get_instagram_userid($alias)
	{
		$cache_key = 'fetch_userid_' . $alias;
		$cache = $this->cache->get($cache_key);

		if ( $cache != null )
		{
			return $this->cache->get($cache_key);
		}

		$user_id = false;
		
		$possible_users = $this->instagram_api->searchUser($alias);

		if ( isset($possible_users->data) && !empty($possible_users->data) )
		{
			foreach ($possible_users->data as $user) {

				if($user->username === $alias)
				{
					$user_id = $user->id;
					break;
				}
			}
		}

		if ($user_id !== false)
		{
			$this->cache->set($cache_key, $user_id, $this->cache_expire);
		}

		return $user_id;
	}



	// ---------------------------------
	// Format results for timeline. Move?
	// ---------------------------------
	private function _format_result($type, $data)
	{
		if ( empty($data) ) return array();

		$formatted_array = array();

		if ($type === 'instgram')
		{
			foreach ($data as $response) {
				$result = array(
					'id'			=> 'instagram-' . $response->id,
					'type'			=> 'socialfeed',
					'source' 		=> 'instagram',
					'media_type'	=> $response->type,
					'date'			=> $response->created_time,
					'image' 		=> $response->images->standard_resolution->url,
					'image_low' 	=> $response->images->low_resolution->url,
					'author'		=> $response->user->full_name,
					'authorLink'	=> 'https://instagram.com/' . $response->user->username . '/',
					'text'			=> '',
					'link'			=> $response->link
				);

				if ( isset($response->videos) ) {
					$result['video']		= $response->videos->standard_resolution->url;
					$result['video_low']	= $response->videos->low_resolution->url;
				}

				if ( isset($response->caption) ) {
					$result['text'] = $response->caption->text;
				}

				$formatted_array[] = $result;
			}
		}
		else if ($type === 'twitter')
		{
			$utc = new DateTimeZone('UTC');

			foreach ($data as $tweet) {
				$created = new DateTime($tweet->created_at, $utc);

				$result = array(
					'id'			=> 'tweet-' . $tweet->id_str,
					'type'			=> 'socialfeed',
					'source' 		=> 'twitter',
					'media_type'	=> 'text',
					'date'			=> $created->format('U'),
					'author'		=> $tweet->user->name,
					'authorLink'	=> 'https://twitter.com/' . $tweet->user->screen_name . '/',
					'text'			=> $tweet->text,
					'link'			=>'https://twitter.com/' . $tweet->user->screen_name . '/status/' . $tweet->id_str . '/'
				);

				if ( isset($tweet->entities->media) ) {
					$media = $tweet->entities->media[0];

					$result['image']		= $media->media_url_https . ':medium';
					$result['image_low']	= $media->media_url_https . ':small';
				}

				$formatted_array[] = $result;
			}
		}

		return $formatted_array;
	}


	// ---------------------------------
	// Sort by date. Move?
	// ---------------------------------
    static function sort_feed($a, $b)
    {
        return ($a['date'] - $b['date']);
    }
}

$rocke_social_feeds = new Rocke_social_feeds();