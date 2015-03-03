<?php

  namespace Kps3\Framework\Mappers {

    use Kps3\Framework\Exceptions\InternalException;
    use Kps3\Framework\Interfaces\TrackDatesInterface;
    use Kps3\Framework\Models\BaseEntity;

    abstract class BaseDbMapper extends BaseMapper {

      /**
       * Gets an associated array of fields that are used to create a record in the database.  The key of the array
       * is the column name, the value of the element in the array is the value that will be saved in the database. Will
       * automagically change updated and created date for models that implement the TrackDatesInterface
       * @param BaseEntity $entity
       * @returns array
       * @throws InternalException
       */
      public function GetCreateFields(BaseEntity $entity) {
        $fields = $this->doGetCreateFields($entity);
        if ($entity instanceof TrackDatesInterface) {
          $fields += [
            'modified_date' => \Carbon::now(),
            'created_date' => \Carbon::now()
          ];
        }
      }

      /**
       * Gets an associated array of fields that are used to update a record in the database.  The key of the array
       * is the column name, the value of the element in the array is the value that will be saved in the database.
       * This list should not include the primary key values.  Will automagically change updated date for models
       * that implement the TrackDatesInterface
       * @param BaseEntity $entity
       * @returns array
       * @throws InternalException
       */
      public function GetUpdateFields(BaseEntity $entity) {
        $fields = $this->doGetUpdateFields($entity);
        if ($entity instanceof TrackDatesInterface) {
          $fields += [
            'modified_date' => \Carbon::now()
          ];
        }
      }

      protected function doGetUpdateFields(BaseEntity $entity) {
        throw new InternalException('Not Implemented');
      }

      protected function doGetCreateFields(BaseEntity $entity) {
        throw new InternalException('Not Implemented');
      }

      abstract public function GetTableName();

      abstract public function GetPrimaryKey();

    }
  }

