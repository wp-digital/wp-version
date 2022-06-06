<?php

namespace Innocode\Version;

class Version
{
    /**
     * @var string
     */
    protected $option;

    /**
     * @param string $option
     *
     * @return void
     */
    public function set_option( string $option ) : void
    {
        $this->option = $option;
    }

    /**
     * @return string
     */
    public function get_option() : string
    {
        return $this->option;
    }

    /**
     * @return bool
     */
    public function init() : bool
    {
        if ( null !== $this() ) {
            return false;
        }

        return $this->bump();
    }

    /**
     * @return bool
     */
    public function bump() : bool
    {
        return $this->update( static::generate() );
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function update( string $value ) : bool
    {
        return function_exists( 'update_option' ) && update_option( $this->get_option(), $value );
    }

    /**
     * @return bool
     */
    public function delete() : bool
    {
        return function_exists( 'delete_option' ) && delete_option( $this->get_option() );
    }

    /**
     * @return string|null
     */
    public function __invoke() : ?string
    {
        $option = $this->get_option();

        if ( ! $option ) {
            return null;
        }

        return function_exists( 'get_option' ) ? get_option( $this->get_option(), null ) : null;
    }

    /**
     * @return string
     */
    public static function generate() : string
    {
        return md5( time() );
    }
}
