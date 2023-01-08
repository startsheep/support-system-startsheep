import admin from "./users/admin";
import customer from "./users/customer";
import staff from "./users/staff";

export default [...admin, ...staff, ...customer];
