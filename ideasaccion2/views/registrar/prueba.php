<style>
    .inputdemoIcons {
  /*
.right-icon {
  position: absolute;
  top: 4px;
  right: 2px;
  left: auto;
  margin-top: 0;
}
*/ }
  .inputdemoIcons .inputIconDemo {
    min-height: 48px; }
  .inputdemoIcons md-input-container:not(.md-input-invalid) > md-icon.email {
    color: green; }
  .inputdemoIcons md-input-container:not(.md-input-invalid) > md-icon.name {
    color: dodgerblue; }
  .inputdemoIcons md-input-container.md-input-invalid > md-icon.email,
  .inputdemoIcons md-input-container.md-input-invalid > md-icon.name {
    color: red; }
</style>
  <br/>
  <md-content class="md-no-momentum">
    <md-input-container class="md-icon-float md-block">
      <!-- Use floating label instead of placeholder -->
      <label>Name</label>
      <md-icon md-svg-src="img/icons/ic_person_24px.svg" class="name"></md-icon>
      <input ng-model="user.name" type="text">
    </md-input-container>
    <md-input-container md-no-float class="md-block">
      <md-icon md-svg-src="img/icons/ic_phone_24px.svg"></md-icon>
      <input ng-model="user.phone" type="text" placeholder="Phone Number">
    </md-input-container>
    <md-input-container class="md-block">
      <!-- Use floating placeholder instead of label -->
      <md-icon md-svg-src="img/icons/ic_email_24px.svg" class="email"></md-icon>
      <input ng-model="user.email" type="email" placeholder="Email (required)" ng-required="true">
    </md-input-container>
    <md-input-container md-no-float class="md-block">
      <input ng-model="user.address" type="text" placeholder="Address" >
      <md-icon md-svg-src="img/icons/ic_place_24px.svg" style="display:inline-block;"></md-icon>
    </md-input-container>
    <md-input-container class="md-icon-float md-icon-right md-block">
      <label>Donation Amount</label>
      <md-icon md-svg-src="img/icons/ic_card_giftcard_24px.svg"></md-icon>
      <input ng-model="user.donation" type="number" step="0.01">
      <md-icon md-svg-src="img/icons/ic_euro_24px.svg"></md-icon>
    </md-input-container>
  </md-content>

