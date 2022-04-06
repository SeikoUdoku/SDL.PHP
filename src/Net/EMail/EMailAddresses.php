<?php
namespace Jp\Skud\Sdl\Net\EMail;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Jp\Skud\Sdl\Collection\Collection;
use Jp\Skud\Sdl\Collection\IArrayable;
use Jp\Skud\Sdl\Collection\Sdq\Sdq;
use Traversable;

/**
 * Eメールアドレスの集合を表現するクラス
 */
class EMailAddresses implements ArrayAccess, Countable, IArrayable, IteratorAggregate
{
    // ================================================================
    // 変数
    // ================================================================
    /** @var Collection|EMailAddress[] Eメールアドレスの集合 */
    protected Collection $addresses;






    // ================================================================
    // 関数
    // ================================================================
    /**
     * コンストラクタ
     *
     * @param iterable|EMailAddress[] $addresses
     */
    public function __construct(iterable $addresses = [])
    {
        $this->addresses = new Collection($addresses);
    }




    /**
     * Eメールアドレスが存在するか判定する。
     *
     * @param EMailAddress $eMailAddress
     * @return bool
     */
    public function contains(EMailAddress $eMailAddress) : bool
    {
        return $this->containsAddress($eMailAddress->getAddress());
    }




    /**
     * 任意のアドレスのEメールアドレスが含まれるか判定する。
     *
     * @param string $address
     * @return bool
     */
    public function containsAddress(string $address) : bool
    {
        return Sdq::from($this->addresses)->any(function(int $key, EMailAddress $eMailAddress) use($address) : bool
        {
            return $address === $eMailAddress->getAddress();
        });
    }




    /**
     * 任意の名前のEメールアドレスが含まれるか判定する。
     *
     * @param string $name
     * @return bool
     */
    public function containsName(string $name) : bool
    {
        return Sdq::from($this->addresses)->any(function(int $key, EMailAddress $value) use($name) : bool
        {
            return $name === $value->getName();
        });
    }




    /**
     * 任意のEメールアドレスを取得する。
     *
     * @param EMailAddress|string $address
     * @return EMailAddress
     */
    public function get(string $address) : EMailAddress
    {
        if($address instanceof EMailAddress)
        {
            $address = $address->getAddress();
        }

        return $this->addresses->get($address);
    }




    /**
     * 任意のEメールアドレスを取得する。
     *
     * @param EMailAddress|string $address
     * @param mixed $default
     * @return EMailAddress|null
     */
    public function tryGet(EMailAddress|string $address, ?EMailAddress $default = null) : ?EMailAddress
    {
        if($address instanceof EMailAddress)
        {
            $address = $address->getAddress();
        }

        return $this->addresses->tryGet($address, $default);
    }




    /**
     * Eメールアドレスを追加する。
     *
     * @param EMailAddress|string $address
     * @return static
     */
    public function add(EMailAddress|string $address) : static
    {
        if(is_string($address))
        {
            $address = EMailAddress::from($address);
        }

        $this->addresses->add($address, $address->getAddress());
        return $this;
    }




    /**
     * Eメールアドレスを追加する。
     *
     * @param EMailAddress|string $address
     * @return bool
     */
    public function tryAdd(EMailAddress|string $address) : bool
    {
        if(is_string($address))
        {
            $address = EMailAddress::from($address);
        }

        return $this->addresses->tryAdd($address, $address->getAddress());
    }




    /**
     * Eメールアドレスを更新する。
     *
     * @param EMailAddress|string $address
     * @return static
     */
    public function update(EMailAddress|string $address) : static
    {
        if(is_string($address))
        {
            $address = EMailAddress::from($address);
        }

        $this->addresses->update($address->getAddress(), $address);
        return $this;
    }




    /**
     * Eメールアドレスを更新する。
     *
     * @param EMailAddress|string $address
     * @return bool
     */
    public function tryUpdate(EMailAddress|string $address) : bool
    {
        if(is_string($address))
        {
            $address = EMailAddress::from($address);
        }

        return $this->addresses->tryUpdate($address->getAddress(), $address);
    }




    /**
     * Eメールアドレスを設定する。
     *
     * @param EMailAddress|string $address
     * @return static
     */
    public function setElement(EMailAddress|string $address) : static
    {
        if(is_string($address))
        {
            $address = EMailAddress::from($address);
        }

        $this->addresses->setElement($address->getAddress(), $address);
        return $this;
    }




    /**
     * Eメールアドレスを削除する。
     *
     * @param EMailAddress|string $address
     * @return static
     */
    public function remove(EMailAddress|string $address) : static
    {
        if($address instanceof EMailAddress)
        {
            $address = $address->getAddress();
        }

        $this->addresses->remove($address);
        return $this;
    }




    /**
     * Eメールアドレスを削除する。
     *
     * @param EMailAddress|string $address
     * @return bool
     */
    public function tryRemove(EMailAddress|string $address) : bool
    {
        if($address instanceof EMailAddress)
        {
            $address = $address->getAddress();
        }

        return $this->addresses->tryRemove($address);
    }




    /**
     * Eメールアドレスを全て削除する。
     *
     * @return static
     */
    public function clear() : static
    {
        $this->addresses->clear();
        return $this;
    }




    /**
     * Eメールアドレスの集合を配列に変換する。
     *
     * @return EMailAddress[]
     */
    public function toArray() : array
    {
        return $this->addresses->toArray();
    }




    /**
     * @inheritdoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->addresses->offsetExists($offset);
    }




    /**
     * @inheritdoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->addresses->offsetGet($offset);
    }




    /**
     * @inheritdoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->addresses->offsetSet($offset, $value);
    }




    /**
     * @inheritdoc
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->addresses->offsetUnset($offset);
    }




    /**
     * @inheritdoc
     */
    public function count(): int
    {
        return $this->addresses->count();
    }




    /**
     * @inheritdoc
     * @return Traversable|EMailAddress[]
     */
    public function getIterator(): Traversable
    {
        return $this->addresses->getIterator();
    }
}
