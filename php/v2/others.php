<?php

namespace NW\WebService\References\Operations\Notification;

/**
 * @property Seller $Seller
 */
class Contractor
{
    const TYPE_CUSTOMER = 0;
    protected $id;
    protected $type;
    protected $name;
		
    function __construct(int $resellerId)
		{
			if($result = $this->getResseller($resellerId))
			{
				$this->id = $resellerId;
				$this->type = self::TYPE_CUSTOMER;
				$this->name = $result['name'];
				$this->Seller = new Seller($resellerId);
			}
			else
			{
				return null;
			}
		}

	  public static function getById(int $resellerId): self
    {
        return new static($resellerId);
    }

    public function getFullName(): string
    {
        return $this->name . ' ' . $this->id;
    }
    
    public function getName()
		{
			return $this->name;
		}
		
    public function getType()
		{
			return $this->type;
		}
		
    public function getId()
		{
			return $this->id;
		}
		
		protected function getResseller(int $resellerId)
		{
			// fakes datas, immitation request DB
			if(true)
			{
				return ['name' => 'Ivan Koltakov'];
			}
			else
			{
				return null;
			}
			
		}
}

class Seller extends Contractor
{
	const TYPE_CUSTOMER = 1;
}

class Employee extends Contractor
{
	const TYPE_CUSTOMER = 2;
}

class Status
{
	  const COMPLETE = 'Completed';
	  const PENDING = 'Pending';
	  const REJECTED = 'Rejected';
	  
	  protected static $statuses = [
			0 => self::COMPLETE,
			1 => self::PENDING,
			2 => self::REJECTED,
		];
	  
    public $id, $name;

    public static function getName(int $id): string
    {
    	  if (!isset(self::$statuses[$id]))
				{
					throw new \Exception("unknown id", 400);
				}
    	  
        return self::$statuses[$id];
    }
}

abstract class ReferencesOperation
{
    abstract public function doOperation(): array;

    public function getRequest($pName)
    {
    	  if (!isset($_REQUEST[$pName]))
				{
					throw new \Exception("unknown request param", 400);
				}
    	  
        return $_REQUEST[$pName];
    }
}

function getResellerEmailFrom()
{
    return 'contractor@example.com';
}

function getEmailsByPermit($resellerId, $event)
{
    // fakes the method
    return ['someemeil@example.com', 'someemeil2@example.com'];
}

class NotificationEvents
{
    const CHANGE_RETURN_STATUS = 'changeReturnStatus';
    const NEW_RETURN_STATUS    = 'newReturnStatus';
}