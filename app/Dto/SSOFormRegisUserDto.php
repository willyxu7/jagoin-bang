<?php


namespace App\Dto;


class SSOFormRegisUserDto
{

    private string $username;
    private string $email;
    private string $placeOfBirth;
    private string $dateOfBirth;
    private string $gender;
    private string $address;
    private string $province;
    private string $city;
    private string $district;
    private string $zipCode;
    private string $phoneNumber;
    private string $faxNumber;
    private string $randomPassword;
    private bool $enabled = true;
    private bool $temporary = false;

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceOfBirth(): string
    {
        return $this->placeOfBirth;
    }

    /**
     * @param string $placeOfBirth
     */
    public function setPlaceOfBirth(string $placeOfBirth): self
    {
        $this->placeOfBirth = $placeOfBirth;

        return $this;
    }

    /**
     * @return string
     */
    public function getDateOfBirth(): string
    {
        return $this->dateOfBirth;
    }

    /**
     * @param string $dateOfBirth
     */
    public function setDateOfBirth(string $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address ?? '';
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string
     */
    public function getProvince(): string
    {
        return $this->province ?? '';
    }

    /**
     * @param string $province
     */
    public function setProvince(string $province): self
    {
        $this->province = $province;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city ?? '';
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getDistrict(): string
    {
        return $this->district ?? '';
    }

    /**
     * @param string $district
     */
    public function setDistrict(string $district): self
    {
        $this->district = $district;

        return $this;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode ?? '';
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber ?? '';
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getFaxNumber(): string
    {
        return $this->faxNumber ?? '';
    }

    /**
     * @param string $faxNumber
     */
    public function setFaxNumber(string $faxNumber): self
    {
        $this->faxNumber = $faxNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getRandomPassword(): string
    {
        return $this->randomPassword;
    }

    /**
     * @param string $randomPassword
     */
    public function setRandomPassword(string $randomPassword): self
    {
        $this->randomPassword = $randomPassword;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTemporary(): bool
    {
        return $this->temporary;
    }

    /**
     * @param bool $temporary
     */
    public function setTemporary(bool $temporary): self
    {
        $this->temporary = $temporary;

        return $this;
    }

}
