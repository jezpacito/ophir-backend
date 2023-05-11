<?php

namespace App\Types\Newsfeed;

enum NewsfeedTypes
{
    case ARTICLES;
    case VIDEOS;
    case PHOTOS;
    case FEATURED_AT_NEWSFEED;
    case FEATURED_AT_ALL_CONTENT_PAGES;
    case FEATURED_AT_MOMENTS;
    case FEATURED_AT_MOMENT_PHOTOS;
    case VIDEO_LOBBY_TOGGLE;

    public function label(): string
    {
        return match ($this) {
            self::ARTICLES,
            self::VIDEOS,
            self::PHOTOS => 'Photos',
            self::FEATURED_AT_NEWSFEED => 'Featured At NewsFeed',
            self::FEATURED_AT_ALL_CONTENT_PAGES => 'Featured at All Content Pages',
            self::FEATURED_AT_MOMENTS => 'Featured at Moments',
            self::VIDEO_LOBBY_TOGGLE => 'Video Lobby Toggle',
            self::FEATURED_AT_MOMENT_PHOTOS => 'Featured at Moments Photos',
        };
    }

    public function displayOptions(): array
    {
        switch ($this) {
            case self::ARTICLES:
                return [
                    self::FEATURED_AT_NEWSFEED->label() => 'Is shown at Newsfeed: Articles',
                    self::FEATURED_AT_ALL_CONTENT_PAGES->label() => 'Is shown at All Content: Articles',
                ];
            case self::VIDEOS:
                return [
                    self::FEATURED_AT_MOMENTS->label() => 'Is shown at Marlboro Moments',
                    self::FEATURED_AT_ALL_CONTENT_PAGES->label() => 'Is shown at All Contents: Videos',
                    self::VIDEO_LOBBY_TOGGLE->label() => 'Watch Now',
                ];
            case self::PHOTOS:
                return [
                    self::FEATURED_AT_MOMENT_PHOTOS->label() => 'Is shown at Marlboro Moments',
                ];
            case self::FEATURED_AT_NEWSFEED:
            case self::FEATURED_AT_ALL_CONTENT_PAGES:
            case self::FEATURED_AT_MOMENTS:
            case self::VIDEO_LOBBY_TOGGLE:
            default:
                return [];
        }
    }

    public static function articleOptions(): array
    {
        return self::ARTICLES->displayOptions();
    }

    public static function videoOptions(): array
    {
        return self::VIDEOS->displayOptions();
    }

    public static function photoOptions(): array
    {
        return self::PHOTOS->displayOptions();
    }
}
